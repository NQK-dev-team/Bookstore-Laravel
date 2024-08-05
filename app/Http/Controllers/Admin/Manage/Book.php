<?php

namespace App\Http\Controllers\Admin\Manage;

use Closure;
use DateTime;
use DateTimeZone;
use App\Models\Order;
use App\Models\Author;
use App\Models\Belong;
use App\Models\Category;
use App\Models\FileCopy;
use App\Models\FileOrder;
use App\Models\PhyiscalCopy;
use Illuminate\Http\Request;
use App\Models\PhysicalOrder;
use Illuminate\Validation\Rule;
use App\Models\FileOrderContain;
use App\Models\Book as BookModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PhysicalOrderContain;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Book extends Controller
{
    public function getCategory($category = null)
    {
        if (!$category)
            return Category::get();

        return Category::where('name', 'ilike', "%{$category}%")->get();
    }

    public function getCategoryByIds($ids)
    {
        return Category::whereIn('id', $ids)->get();
    }

    public function getPublisher($publisher = null)
    {
        if (!$publisher)
            return BookModel::select('publisher')->get()->unique('publisher');

        return BookModel::select('publisher')->where('publisher', 'ilike', "%{$publisher}%")->get()->unique('publisher');
    }

    public function getAuthor($author = null)
    {
        if (!$author)
            return Author::get();

        return Author::where('name', 'ilike', "%{$author}%")->get()->unique('name');
    }

    public function getTotal($category = null, $author = null, $publisher = null, $search = null, $status = true)
    {
        $category = $category ?? '%';
        $author = $author ?? '%';
        $publisher = $publisher ?? '%';
        $search = $search ? '%' . $search . '%' : '%';
        return BookModel::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])->whereHas('authors', function ($query) use ($author) {
            $query->where('name', 'like', $author);
        })->whereHas('categories', function ($query) use ($category) {
            $query->where('name', 'like', $category);
        })->where([
            ['name', 'ilike', $search],
            ['publisher', 'like', $publisher],
            ['status', '=', $status],
        ])->count();
    }

    public function getBooks($category = null, $author = null, $publisher = null, $search = null, $status = true, $offset = 0, $limit = 10)
    {
        $category = $category ?? '%';
        $author = $author ?? '%';
        $publisher = $publisher ?? '%';
        $search = $search ? '%' . $search . '%' : '%';
        return BookModel::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])->whereHas('authors', function ($query) use ($author) {
            $query->where('name', 'like', $author);
        })->whereHas('categories', function ($query) use ($category) {
            $query->where('name', 'like', $category);
        })->where([
            ['name', 'ilike', $search],
            ['publisher', 'like', $publisher],
            ['status', '=', $status],
        ])->offset($offset * $limit)->limit($limit)->orderBy('name', 'asc')->orderBy('edition', 'asc')->get();
    }

    public function getBookInfo($id)
    {
        return BookModel::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])->where('id', $id)->first();
    }

    public function addBook(Request $request)
    {
        $categories = explode(',', $request->bookCategories);
        $temp = explode(',', $request->bookAuthors);
        $authors = [];
        foreach ($temp as $author) {
            $author = trim($author);
            if ($author) {
                $authors[] = $author;
            }
        }
        $validator = Validator::make([
            'bookName' => $request->bookName,
            'bookEdition' => $request->bookEdition,
            'bookIsbn' => $request->bookIsbn,
            'bookCategories' => $categories,
            'bookAuthors' => $authors,
            'bookPublisher' => $request->bookPublisher,
            'bookPublicationDate' => $request->bookPublicationDate,
            'bookDescription' => $request->bookDescription,
            'physicalPrice' => $request->physicalPrice,
            'physicalQuantity' => $request->physicalQuantity,
            'filePrice' => $request->filePrice,
            'bookImages' => $request->file('bookImages'),
            'pdfFiles' => $request->file('pdfFiles'),
        ], [
            'bookEdition' => ['required', 'numeric', 'min:1', Rule::unique('books', 'edition')->where(function ($query) use ($request) {
                return $query->where('name', $request->bookName);
            })],
            'bookName' => ['required', 'string', 'max:255', Rule::unique('books', 'name')->where(function ($query) use ($request) {
                return $query->where('edition', is_numeric($request->bookEdition) ? $request->bookEdition : -1);
            })],
            'bookIsbn' => ['required', 'string', 'size:13', 'regex:/^\d{13}$/', Rule::unique('books', 'isbn')->whereNull('deleted_at')],
            'bookCategories' => 'required|array|min:1',
            'bookCategories.*' => 'required|string|exists:categories,id',
            'bookAuthors' => 'required|array|min:1',
            'bookPublisher' => 'required|string|max:255',
            'bookPublicationDate' => 'required|date',
            'bookDescription' => 'nullable|string|max:2000',
            'physicalPrice' => 'nullable|numeric|min:0',
            'physicalQuantity'  => 'nullable|numeric|min:0',
            'filePrice' => 'nullable|numeric|min:0',
            'bookImages' => 'size:1',
            'bookImages.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'pdfFiles' => 'max:1',
            'pdfFiles.*' => ['nullable', 'mimes:pdf', 'max:512000'],
        ], [
            'bookImages.*.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            'bookImages.*.max' => 'The image size must not be greater than 2MB.',
            'pdfFiles.*.mimes' => 'The file must be a file of type: pdf.',
            'pdfFiles.*.max' => 'The file size must not be greater than 500MB.',
            'bookName.unique' => 'The book name and edition have already been taken.',
            'bookEdition.unique' => 'The book name and edition have already been taken.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.manage.book.add')->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request, $categories, $authors) {
            $id = IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']);
            $date = new DateTime('now', new DateTimeZone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh')));

            $book = new BookModel();
            $book->id = $id;
            $book->name = $request->bookName;
            $book->edition = $request->bookEdition;
            $book->isbn = $request->bookIsbn;
            $book->publisher = $request->bookPublisher;
            $book->publication_date = $request->bookPublicationDate;
            $book->description = $request->bookDescription;
            $imagePath = Storage::putFileAs('files/images/books/' . $id, $request->file('bookImages')[0], $date->format('YmdHis') . '.' . $request->file('bookImages')[0]->extension());
            $book->image = $imagePath;
            $book->save();

            foreach ($categories as $category) {
                $belongs = new Belong();
                $belongs->book_id = $id;
                $belongs->category_id = $category;
                $belongs->save();
            }

            foreach ($authors as $author) {
                $authorModel = new Author();
                $authorModel->book_id = $id;
                $authorModel->name = $author;
                $authorModel->save();
            }

            if ($request->physicalPrice !== null || $request->physicalQuantity !== null) {
                $physicalCopy = new PhyiscalCopy();
                $physicalCopy->id = $id;
                $physicalCopy->price = $request->physicalPrice !== null ? $request->physicalPrice : null;
                $physicalCopy->quantity = $request->physicalQuantity !== null ? $request->physicalQuantity : null;
                $physicalCopy->save();
            }

            if ($request->filePrice !== null || $request->hasFile('pdfFiles')) {
                $fileCopy = new FileCopy();
                $fileCopy->id = $id;
                $fileCopy->price = $request->filePrice !== null ? $request->filePrice : null;
                if ($request->hasFile('pdfFiles')) {
                    $pdfPath = Storage::putFileAs('files/pdfs/books/' . $id, $request->file('pdfFiles')[0], $date->format('YmdHis') . '.' . $request->file('pdfFiles')[0]->extension());
                    $fileCopy->path = $pdfPath;
                }
                $fileCopy->save();
            }

            session()->flash('book-added', 1);
        });

        return redirect()->route('admin.manage.book.index');
    }

    public function updateBook(Request $request)
    {
        $categories = explode(',', $request->bookCategories);
        $temp = explode(',', $request->bookAuthors);
        $authors = [];
        foreach ($temp as $author) {
            $author = trim($author);
            if ($author) {
                $authors[] = $author;
            }
        }
        $validator = Validator::make([
            'bookName' => $request->bookName,
            'bookEdition' => $request->bookEdition,
            'bookIsbn' => $request->bookIsbn,
            'bookCategories' => $categories,
            'bookAuthors' => $authors,
            'bookPublisher' => $request->bookPublisher,
            'bookPublicationDate' => $request->bookPublicationDate,
            'bookDescription' => $request->bookDescription,
            'physicalPrice' => $request->physicalPrice,
            'physicalQuantity' => $request->physicalQuantity,
            'filePrice' => $request->filePrice,
            'removeFile' => $request->removeFile,
            'bookImages' => $request->file('bookImages'),
            'pdfFiles' => $request->file('pdfFiles'),
        ], [
            'bookEdition' => ['required', 'numeric', 'min:1', Rule::unique('books', 'edition')->where(function ($query) use ($request) {
                return $query->where('name', $request->bookName);
            })->whereNot('id', $request->id)],
            'bookName' => ['required', 'string', 'max:255', Rule::unique('books', 'name')->where(function ($query) use ($request) {
                return $query->where('edition', is_numeric($request->bookEdition) ? $request->bookEdition : -1);
            })->whereNot('id', $request->id)],
            'bookIsbn' => ['required', 'string', 'size:13', 'regex:/^\d{13}$/', Rule::unique('books', 'isbn')->whereNull('deleted_at')->whereNot('id', $request->id)],
            'bookCategories' => 'required|array|min:1',
            'bookCategories.*' => 'required|string|exists:categories,id',
            'bookAuthors' => 'required|array|min:1',
            'bookPublisher' => 'required|string|max:255',
            'bookPublicationDate' => 'required|date',
            'bookDescription' => 'nullable|string|max:2000',
            'physicalPrice' => 'nullable|numeric|min:0',
            'physicalQuantity'  => 'nullable|numeric|min:0',
            'filePrice' => 'nullable|numeric|min:0',
            'bookImages' => 'max:1',
            'bookImages.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'pdfFiles' => 'max:1',
            'pdfFiles.*' => ['nullable', 'mimes:pdf', 'max:512000'],
            'removeFile' => [
                function (string $attribute, mixed $value, Closure $fail)
                use ($request) {
                    if ($value) {
                        if (Order::whereHas(
                            'fileOrder.fileCopies',
                            function (Builder $query) use ($request) {
                                $query->where('file_copies.id', $request->id);
                            }
                        )->where([
                            ['status', '=', true]
                        ])->exists())
                            $fail('Ebook has been bought by the customer(s).');
                    }
                }
            ],
        ], [
            'bookImages.*.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            'bookImages.*.max' => 'The image size must not be greater than 2MB.',
            'pdfFiles.*.mimes' => 'The file must be a file of type: pdf.',
            'pdfFiles.*.max' => 'The file size must not be greater than 500MB.',
            'bookName.unique' => 'The book name and edition have already been taken.',
            'bookEdition.unique' => 'The book name and edition have already been taken.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.manage.book.detail', ["id" => $request->id])->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request, $categories, $authors) {
            $id = $request->id;
            $date = new DateTime('now', new DateTimeZone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh')));

            $book = BookModel::find($id);
            $book->name = $request->bookName;
            $book->edition = $request->bookEdition;
            $book->isbn = $request->bookIsbn;
            $book->publisher = $request->bookPublisher;
            $book->publication_date = $request->bookPublicationDate;
            $book->description = $request->bookDescription;
            if ($request->hasFile('bookImages')) {
                $imagePath = Storage::putFileAs('files/images/books/' . $id, $request->file('bookImages')[0], $date->format('YmdHis') . '.' . $request->file('bookImages')[0]->extension());
                $book->image = $imagePath;
            }
            $book->save();

            Belong::where('book_id', $id)->delete();
            foreach ($categories as $category) {
                $belongs = new Belong();
                $belongs->book_id = $id;
                $belongs->category_id = $category;
                $belongs->save();
            }

            Author::where('book_id', $id)->delete();
            foreach ($authors as $author) {
                $authorModel = new Author();
                $authorModel->book_id = $id;
                $authorModel->name = $author;
                $authorModel->save();
            }

            $physicalCopy = PhyiscalCopy::find($id);
            if ($physicalCopy) {
                $physicalCopy->price = $request->physicalPrice !== null ? $request->physicalPrice : null;
                $physicalCopy->quantity = $request->physicalQuantity !== null ? $request->physicalQuantity : null;
                $physicalCopy->save();

                if ($physicalCopy->quantity === null && $physicalCopy->price === null) {
                    $physicalCopy->delete();
                    $this->removeBookFromCarts($id);
                } else if ($physicalCopy->quantity === null || $physicalCopy->price === null) {
                    $this->removeBookFromCarts($id, 1);
                }
            } else if ($request->physicalPrice !== null || $request->physicalQuantity !== null) {
                $physicalCopy = new PhyiscalCopy();
                $physicalCopy->id = $id;
                $physicalCopy->price = $request->physicalPrice !== null ? $request->physicalPrice : null;
                $physicalCopy->quantity = $request->physicalQuantity !== null ? $request->physicalQuantity : null;
                $physicalCopy->save();
            }

            $fileCopy = FileCopy::find($id);
            if ($fileCopy) {
                if ($request->removeFile) {
                    $fileCopy->path = null;
                }
                $fileCopy->price = $request->filePrice !== null ? $request->filePrice : null;
                if ($request->hasFile('pdfFiles')) {
                    $pdfPath = Storage::putFileAs('files/pdfs/books/' . $id, $request->file('pdfFiles')[0], $date->format('YmdHis') . '.' . $request->file('pdfFiles')[0]->extension());
                    $fileCopy->path = $pdfPath;
                }
                $fileCopy->save();

                if ($fileCopy->price === null && $fileCopy->path === null) {
                    $fileCopy->delete();
                    $this->removeBookFromCarts($id);
                } else if ($fileCopy->price === null || $fileCopy->path === null) {
                    $this->removeBookFromCarts($id, 2);
                }
            } else if ($request->filePrice !== null || ($request->hasFile('pdfFiles') && !$request->removeFile)) {
                $fileCopy = new FileCopy();
                $fileCopy->id = $id;
                $fileCopy->price = $request->filePrice !== null ? $request->filePrice : null;
                if ($request->hasFile('pdfFiles')) {
                    $pdfPath = Storage::putFileAs('files/pdfs/books/' . $id, $request->file('pdfFiles')[0], $date->format('YmdHis') . '.' . $request->file('pdfFiles')[0]->extension());
                    $fileCopy->path = $pdfPath;
                }
                $fileCopy->save();
            }

            session()->flash('info-updated', 1);
        });

        return redirect()->route('admin.manage.book.detail', ['id' => $request->id]);
    }

    public function removeBookFromCarts($bookID, $mode = 3)
    {
        $orders = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])
            ->orWhereHas('physicalOrder.physicalCopies', function (Builder $query) use ($bookID) {
                $query->where('physical_copies.id', $bookID);
            })->orWhereHas(
                'fileOrder.fileCopies',
                function (Builder $query) use ($bookID) {
                    $query->where('file_copies.id', $bookID);
                }
            )
            ->where([
                ['status', '=', false]
            ])->get();

        foreach ($orders as $order) {
            if ($order->physicalOrder && ($mode === 3  || $mode === 1)) {
                $order->physicalOrder->physicalCopies()->detach($bookID);
            }
            if ($order->fileOrder && ($mode === 3  || $mode === 2)) {
                $order->fileOrder->fileCopies()->detach($bookID);
            }
            $order->save();

            if (PhysicalOrder::where('id', $order->id)->exists() && !PhysicalOrderContain::where('order_id', $order->id)->exists())
                PhysicalOrder::where('id', $order->id)->delete();

            if (FileOrder::where('id', $order->id)->exists() && !FileOrderContain::where('order_id', $order->id)->exists())
                FileOrder::where('id', $order->id)->delete();

            if (Order::where('id', $order->id)->exists() && !PhysicalOrder::where('id', $order->id)->exists() && !FileOrder::where('id', $order->id)->exists())
                Order::where('id', $order->id)->delete();

            if (Order::find($order->id))
                recalculateOrderValue($order->id, Order::find($order->id)->customer_id);
        }
    }

    public function deactivateBook($bookID)
    {
        DB::transaction(function () use ($bookID) {
            $this->removeBookFromCarts($bookID);
            BookModel::where('id', $bookID)->update(['status' => false]);
        });
    }

    public function reactivateBook($bookID)
    {
        DB::transaction(function () use ($bookID) {
            BookModel::where('id', $bookID)->update(['status' => true]);
        });
    }

    public function deleteBook($bookID)
    {
        DB::transaction(function () use ($bookID) {
            $this->removeBookFromCarts($bookID);
            BookModel::where('id', $bookID)->delete();
            PhyiscalCopy::where('id', $bookID)->delete();
            FileCopy::where('id', $bookID)->delete();
        });
    }

    // public function isBookBought($bookID)
    // {
    //     return Order::orWhereHas('physicalOrder.physicalCopies', function (Builder $query) use ($bookID) {
    //         $query->where('physical_copies.id', $bookID);
    //     })->orWhereHas(
    //         'fileOrder.fileCopies',
    //         function (Builder $query) use ($bookID) {
    //             $query->where('file_copies.id', $bookID);
    //         }
    //     )->where([
    //         ['status', '=', true]
    //     ])->exists();
    // }

    public function showList()
    {
        return view('admin.manage.book.index');
    }

    public function showAdd()
    {
        return view('admin.manage.book.add');
    }

    public function showDetail(Request $request)
    {
        $book = $this->getBookInfo($request->id);
        if (!$book) {
            abort(404);
        }
        return view('admin.manage.book.detail', ['book' => $book]);
    }
}
