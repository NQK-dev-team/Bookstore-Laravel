<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Models\Order;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Book as BookModel;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

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
        $temp = explode(', ', $request->bookAuthors);
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
            'bookName' => ['required', 'string', 'max:255', Rule::unique('books', 'name')->where(function ($query) use ($request) {
                return $query->where('edition', $request->bookEdition);
            })],
            'bookEdition' => ['required', 'numeric', 'min:1', Rule::unique('books', 'edition')->where(function ($query) use ($request) {
                return $query->where('name', $request->bookName);
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
    }

    public function updateBook(Request $request)
    {
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
