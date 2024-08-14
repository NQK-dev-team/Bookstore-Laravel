<?php

namespace App\Http\Controllers\Customer\Book;

use Exception;
use Carbon\Carbon;
use App\Models\Book;
use App\Models\Order;
use App\Models\Author;
use App\Models\Rating;
use App\Models\Category;
use App\Models\Discount;
use voku\helper\AntiXSS;
use App\Models\FileOrder;
use Illuminate\Http\Request;
use App\Models\PhysicalOrder;
use App\Models\FileOrderContain;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PhysicalOrderContain;
use Illuminate\Database\Eloquent\Builder;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class BookController extends Controller
{
    public function getBestBooksInWeek()
    {
        $orders = Order::with([
            'physicalOrder' => ['physicalCopies'],
            'fileOrder' => ['fileCopies'],
        ])->where([
            ['status', '=', true],
        ])->whereRaw("DATE_PART('week', updated_at) = ?", [date('W')])->get();

        $bookSales = [];

        foreach ($orders as $order) {
            if ($physicalOrder = $order->physicalOrder) {
                foreach ($physicalOrder->physicalCopies as $physicalCopy) {
                    $book = Book::find($physicalCopy->id);
                    if (!$book || !$book->status)
                        continue;
                    if (isset($bookSales[$physicalCopy->id])) {
                        $bookSales[$physicalCopy->id] += $physicalCopy->pivot->amount;
                    } else {
                        $bookSales[$physicalCopy->id] = $physicalCopy->pivot->amount;
                    }
                }
            }

            if ($fileOrder = $order->fileOrder) {
                foreach ($fileOrder->fileCopies as $fileCopy) {
                    $book = Book::find($fileCopy->id);
                    if (!$book || !$book->status)
                        continue;
                    if (isset($bookSales[$fileCopy->id])) {
                        $bookSales[$fileCopy->id]++;
                    } else {
                        $bookSales[$fileCopy->id] = 1;
                    }
                }
            }
        }

        arsort($bookSales, 1);
        return $bookSales;
    }

    public function getDiscountBooksWithParams($author, $category, $publisher, $bookParam)
    {
        $discountedBooks = [];

        $discounts = null;
        $discounts = Discount::with([
            "eventDiscount" => ["booksApplied"],
        ])->whereHas('eventDiscount', function (Builder $query) {
            $query->where([
                ['apply_for_all_books', '=', true],
                ['start_time', '<=', Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))],
                ['end_time', '>=', Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))],
            ]);
        })->where('status', true)->orderBy('discount', 'desc')->first();

        if (!$discounts) {
            $discounts = Discount::with([
                "eventDiscount" => ["booksApplied"],
            ])->whereHas('eventDiscount', function (Builder $query) {
                $query->where([
                    ['apply_for_all_books', '=', false],
                    ['start_time', '<=', Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))],
                    ['end_time', '>=', Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))],
                ]);
            })->where('status', true)->orderBy('discount', 'desc')->get();

            if (!$discounts) return [];
            else {
                foreach ($discounts as $discount) {
                    $books = $discount->eventDiscount->booksApplied;
                    foreach ($books as $book) {
                        if (!$book->status) continue;
                        if (!in_array($book, $discountedBooks))
                            $discountedBooks[] = $book->id;
                    }
                }
            }
        } else {
            $books = Book::all();
            foreach ($books as $book) {
                if (!$book->status) continue;
                $discountedBooks[] = $book->id;
            }
        }

        $bookSales = $this->getBestBooksInWeek();
        $bookIDs = array_keys($bookSales);
        $temp = $discountedBooks;
        $discountedBooks = array_intersect($bookIDs, $discountedBooks);

        if (count($discountedBooks) < count($temp)) {
            $moreBooks = array_diff($temp, $discountedBooks);
            $moreBooks = array_slice($moreBooks, 0, count($temp) - count($discountedBooks), true);
            $discountedBooks = array_merge($discountedBooks, $moreBooks);
        }

        $temp = $discountedBooks;
        $discountedBooks = [];
        foreach ($temp as $id) {
            $discountedBooks[] = Book::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])
                ->whereHas('authors', function ($query) use ($author) {
                    $query->where('name', 'like',  $author);
                })->whereHas('categories', function ($query) use ($category) {
                    $query->where('name', 'like', $category);
                })
                ->where([
                    ['id', '=', $id],
                    ['name', 'ilike', '%' . ($bookParam ? trim($bookParam) : '') . '%'],
                    ['publisher', 'like', $publisher],
                    ['status', '=', true],
                ])->first();
        }

        return $discountedBooks;
    }

    public function getDiscountBooks()
    {
        $discountedBooks = [];

        $discounts = null;
        $discounts = Discount::with([
            "eventDiscount" => ["booksApplied"],
        ])->whereHas('eventDiscount', function (Builder $query) {
            $query->where([
                ['apply_for_all_books', '=', true],
                ['start_time', '<=', Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))],
                ['end_time', '>=', Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))],
            ]);
        })->where('status', true)->orderBy('discount', 'desc')->first();

        if (!$discounts) {
            $discounts = Discount::with([
                "eventDiscount" => ["booksApplied"],
            ])->whereHas('eventDiscount', function (Builder $query) {
                $query->where([
                    ['apply_for_all_books', '=', false],
                    ['start_time', '<=', Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))],
                    ['end_time', '>=', Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))],
                ]);
            })->where('status', true)->orderBy('discount', 'desc')->get();

            if (!$discounts) return [];
            else {
                foreach ($discounts as $discount) {
                    $books = $discount->eventDiscount->booksApplied;
                    foreach ($books as $book) {
                        if (!$book->status) continue;
                        if (!in_array($book, $discountedBooks))
                            $discountedBooks[] = $book->id;
                    }
                }
            }
        } else {
            $books = Book::all();
            foreach ($books as $book) {
                if (!$book->status) continue;
                $discountedBooks[] = $book->id;
            }
        }

        $bookSales = $this->getBestBooksInWeek();
        $bookIDs = array_keys($bookSales);
        $temp = $discountedBooks;
        $discountedBooks = array_intersect($bookIDs, $discountedBooks);

        if (count($discountedBooks) < 15) {
            $moreBooks = array_diff($temp, $discountedBooks);
            $moreBooks = array_slice($moreBooks, 0, 15 - count($discountedBooks), true);
            $discountedBooks = array_merge($discountedBooks, $moreBooks);
        }

        $temp = $discountedBooks;
        $discountedBooks = [];
        foreach ($temp as $id) {
            $discountedBooks[] = refineBookData(Book::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])->where('status', true)->find($id));
        }

        return $discountedBooks;
    }

    public function getTopCategories()
    {
        $bookSales = $this->getBestBooksInWeek();
        $bookIDs = array_keys($bookSales);

        $books = Book::with("categories")->whereIn('id', $bookIDs)->where('status', true)->get();
        $topCategories = [];

        foreach ($books as $book) {
            foreach ($book->categories as $category) {
                if (isset($topCategories[$category->name])) {
                    $topCategories[$category->name] += $bookSales[$book->id];
                } else {
                    $topCategories[$category->name] = $bookSales[$book->id];
                }
            }
        }

        arsort($topCategories, 1);
        $categoryNames = array_keys($topCategories);
        $categoryNames = array_slice($categoryNames, 0, 5, true);

        if (count($categoryNames) < 5) {
            $categories = Category::whereNotIn('name', $categoryNames)->limit(5 - count($categoryNames))->distinct()->get();
            foreach ($categories as $category) {
                if (!in_array($category->name, $categoryNames))
                    $categoryNames[] = $category->name;
            }
        }

        return $categoryNames;
    }

    public function getTopPublishers()
    {
        $bookSales = $this->getBestBooksInWeek();
        $bookIDs = array_keys($bookSales);

        $books = Book::whereIn('id', $bookIDs)->where('status', true)->get();
        $topPublishers = [];

        foreach ($books as $book) {
            if (isset($topPublishers[$book->publisher])) {
                $topPublishers[$book->publisher] += $bookSales[$book->id];
            } else {
                $topPublishers[$book->publisher] = $bookSales[$book->id];
            }
        }

        arsort($topPublishers, 1);
        $publisherNames = array_keys($topPublishers);
        $publisherNames = array_slice($publisherNames, 0, 5, true);

        if (count($publisherNames) < 5) {
            $publishers = Book::select('publisher')->whereNotIn('publisher', $publisherNames)->where('status', true)->limit(5 - count($publisherNames))->distinct()->get();
            foreach ($publishers as $publisher) {
                if (!in_array($publisher->publisher, $publisherNames))
                    $publisherNames[] = $publisher->publisher;
            }
        }

        return $publisherNames;
    }

    public function getTopAuthors()
    {
        $bookSales = $this->getBestBooksInWeek();
        $bookIDs = array_keys($bookSales);

        $books = Book::with("authors")->whereIn('id', $bookIDs)->where('status', true)->get();
        $topAuthors = [];

        foreach ($books as $book) {
            foreach ($book->authors as $author) {
                if (isset($topAuthors[$author->name])) {
                    $topAuthors[$author->name] += $bookSales[$book->id];
                } else {
                    $topAuthors[$author->name] = $bookSales[$book->id];
                }
            }
        }

        arsort($topAuthors, 1);
        $authorNames = array_keys($topAuthors);
        $authorNames = array_slice($authorNames, 0, 5, true);

        if (count($authorNames) < 5) {
            $authors = Author::whereNotIn('name', $authorNames)->limit(5 - count($authorNames))->distinct()->get();
            foreach ($authors as $author) {
                if (!in_array($author->name, $authorNames))
                    $authorNames[] = $author->name;
            }
        }

        return $authorNames;
    }

    public function searchCategory($category)
    {
        if ($category)
            $category = trim($category);
        else
            $category = '';
        return Category::select('name')->where('name', 'ilike', '%' . $category . '%')->distinct()->get();
    }

    public function searchPublisher($publisher)
    {
        if ($publisher)
            $publisher = trim($publisher);
        else
            $publisher = '';
        return Book::select('publisher')->where('publisher', 'ilike', '%' . $publisher . '%')->where('status', true)->distinct()->get();
    }

    public function searchAuthor($author)
    {
        if ($author)
            $author = trim($author);
        else
            $author = '';
        return Author::select('name')->where('name', 'ilike', '%' . $author . '%')->distinct()->get();
    }

    public function searchBook($option, $author, $category, $publisher, $book, $offset, $limit)
    {
        switch ($option) {
            case 1:
                return Book::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])->whereHas('authors', function ($query) use ($author) {
                    $query->where('name', 'like',  $author);
                })->whereHas('categories', function ($query) use ($category) {
                    $query->where('name', 'like',  $category);
                })->where([
                    ['name', 'ilike', '%' . ($book ? trim($book) : '') . '%'],
                    ['publisher', 'like',  $publisher],
                    ['status', '=', true],
                ])->offset($offset * $limit)->limit($limit)->get();
            case 2:
                return array_slice($this->getDiscountBooksWithParams($author, $category, $publisher, $book), $offset * $limit, $limit);
            case 3: {
                    $bookSales = $this->getBestBooksInWeek();
                    $bookIDs = array_keys($bookSales);

                    $result = [];
                    foreach ($bookIDs as $id) {
                        $result[] = Book::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])
                            ->whereHas('authors', function ($query) use ($author) {
                                $query->where('name', 'like',  $author);
                            })->whereHas('categories', function ($query) use ($category) {
                                $query->where('name', 'like', $category);
                            })
                            ->where([
                                ['id', '=', $id],
                                ['name', 'ilike', '%' . ($book ? trim($book) : '') . '%'],
                                ['publisher', 'like', $publisher],
                                ['status', '=', true],
                            ])->first();
                    }
                    return array_slice($result, $offset * $limit, $limit);
                }
            case 4:
                return Book::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])
                    ->whereHas('authors', function ($query) use ($author) {
                        $query->where('name', 'like',  $author);
                    })
                    ->whereHas('categories', function ($query) use ($category) {
                        $query->where('name', 'like',  $category);
                    })
                    ->where([
                        ['name', 'ilike', '%' . ($book ? trim($book) : '') . '%'],
                        ['publisher', 'like',  $publisher],
                        ['status', '=', true],
                    ])
                    ->join('physical_copies', 'books.id', '=', 'physical_copies.id')
                    ->orderBy('physical_copies.price', 'asc')
                    ->offset($offset * $limit)
                    ->limit($limit)
                    ->select('books.*') // Ensure only book fields are selected after join
                    ->get();
            case 5:
                return Book::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])
                    ->whereHas('authors', function ($query) use ($author) {
                        $query->where('name', 'like', '%' . $author . '%');
                    })
                    ->whereHas('categories', function ($query) use ($category) {
                        $query->where('name', 'like', '%' . $category . '%');
                    })
                    ->where([
                        ['name', 'ilike', '%' . ($book ? trim($book) : '') . '%'],
                        ['publisher', 'like', '%' . $publisher . '%'],
                        ['status', '=', true],
                    ])
                    ->join('physical_copies', 'books.id', '=', 'physical_copies.id')
                    ->orderBy('physical_copies.price', 'desc')
                    ->offset($offset * $limit)
                    ->limit($limit)
                    ->select('books.*') // Ensure only book fields are selected after join
                    ->get();
        }
    }

    public function showList()
    {
        return view('customer.book.index');
    }

    public function getBook($id)
    {
        return Book::with(['categories', 'authors', 'physicalCopy', 'fileCopy'])->where('status', true)->find($id);
    }

    public function checkCustomerBoughtBook($id)
    {
        if (!auth()->check()) {
            return false;
        }
        $result = Order::where(function (Builder $query) use ($id) {
            $query->orWhereHas('physicalOrder.physicalCopies', function (Builder $sub_query) use ($id) {
                $sub_query->where('physical_copies.id', $id);
            })->orWhereHas(
                'fileOrder.fileCopies',
                function (Builder $sub_query) use ($id) {
                    $sub_query->where('file_copies.id', $id);
                }
            );
        })->where([
            ['customer_id', '=', auth()->id()],
            ['status', '=', true]
        ])->exists();

        return $result;
    }

    public function getCustomerRating($id)
    {
        if (!auth()->check()) {
            return null;
        }

        return Rating::where([
            ['customer_id', '=', auth()->id()],
            ['book_id', '=', $id]
        ])->first();
    }

    public function submitRating($book_id, $rating, $comment)
    {
        if (!auth()->check()) {
            abort(401);
        }

        $antiXss = new AntiXSS();

        DB::transaction(function () use ($book_id, $rating, $comment, $antiXss) {
            if (Rating::where([
                ['customer_id', '=', auth()->id()],
                ['book_id', '=', $book_id]
            ])->exists())
                Rating::where([
                    ['customer_id', '=', auth()->id()],
                    ['book_id', '=', $book_id]
                ])->update(
                    ['star' => $antiXss->xss_clean($rating), 'comment' => $comment ? $antiXss->xss_clean($comment) : null],
                );
            else
                Rating::create([
                    'customer_id' => auth()->id(),
                    'book_id' => $book_id,
                    'star' => $antiXss->xss_clean($rating),
                    'comment' => $comment ? $antiXss->xss_clean($comment) : null
                ]);

            $new_average_rating = Rating::where('book_id', $book_id)->avg('star');
            Book::where([
                ['id', '=', $book_id],
            ])->update(['average_rating' => $new_average_rating ? $new_average_rating : 0]);
        });
    }

    public function deleteRating($id)
    {
        if (!auth()->check()) {
            abort(401);
        }

        DB::transaction(function () use ($id) {
            Rating::where([
                ['customer_id', '=', auth()->id()],
                ['book_id', '=', $id]
            ])->delete();

            $new_average_rating = Rating::where('book_id', $id)->avg('star');
            Book::where([
                ['id', '=', $id],
            ])->update(['average_rating' => $new_average_rating ? $new_average_rating : 0]);
        });
    }

    public function isRatingExist($id)
    {
        return Rating::where([
            ['book_id', '=', $id]
        ])->exists();
    }

    public function getRatings($id, $numberOfRatings, $filter)
    {
        if (!$filter)
            return Rating::where('book_id', $id)
                ->orderBy('updated_at', 'desc')
                ->limit($numberOfRatings)
                ->join('users', 'users.id', '=', 'ratings.customer_id')
                ->get(['users.name', 'users.image', 'ratings.updated_at', 'ratings.star', 'ratings.comment']);

        return Rating::where('book_id', $id)
            ->orderBy('updated_at', 'desc')
            ->limit($numberOfRatings)
            ->join('users', 'users.id', '=', 'ratings.customer_id')
            ->where([
                ['ratings.star', '=', $filter],
            ])
            ->get(['users.name', 'users.image', 'ratings.updated_at', 'ratings.star', 'ratings.comment']);
    }

    public function addPhysicalToCart($id, $amount)
    {
        if (!auth()->check()) {
            abort(401);
        }

        $order = Order::select('id')->where([
            ['customer_id', '=', auth()->id()],
            ['status', '=', false]
        ])->first();

        DB::transaction(function () use ($id, $amount, $order) {
            if (!$order) {
                $order = Order::create([
                    'id' => IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'O-']),
                    'customer_id' => auth()->id()
                ]);
            }
            $orderID = $order->id;

            if (!PhysicalOrder::where('id', $orderID)->exists())
                PhysicalOrder::create([
                    'id' => $orderID,
                    'address' => auth()->user()->address,
                ]);

            $result = PhysicalOrderContain::where([
                ['order_id', '=', $orderID],
                ['book_id', '=', $id]
            ])->first();

            if ($result) {
                $amount += $result->amount;

                PhysicalOrderContain::where([
                    ['order_id', '=', $orderID],
                    ['book_id', '=', $id]
                ])->update(['amount' => $amount]);
            } else {
                PhysicalOrderContain::create([
                    'order_id' => $orderID,
                    'book_id' => $id,
                    'amount' => $amount,
                ]);
            }

            // Re-calculate the order total price and total discount values
            if (!recalculateOrderValue($orderID)) {
                throw new Exception('Failed to recalculate order.');
            }
        });

        return 0;
    }

    public function addFileToCart($id)
    {
        if (!auth()->check()) {
            abort(401);
        }

        $check = Order::whereHas(
            'fileOrder.fileCopies',
            function (Builder $query) use ($id) {
                $query->where('file_copies.id', $id);
            }
        )->where([
            ['customer_id', '=', auth()->id()],
            ['status', '=', true]
        ])->exists();

        if ($check)
            return 1;

        $check = Order::whereHas(
            'fileOrder.fileCopies',
            function (Builder $query) use ($id) {
                $query->where('file_copies.id', $id);
            }
        )->where([
            ['customer_id', '=', auth()->id()],
            ['status', '=', false]
        ])->exists();

        if ($check)
            return 2;

        $order = Order::select('id')->where([
            ['customer_id', '=', auth()->id()],
            ['status', '=', false]
        ])->first();

        DB::transaction(function () use ($id, $order) {
            if (!$order) {
                $order = Order::create([
                    'id' => IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'O-']),
                    'customer_id' => auth()->id()
                ]);
            }
            $orderID = $order->id;

            if (!FileOrder::where('id', $orderID)->exists())
                FileOrder::create([
                    'id' => $orderID,
                ]);

            FileOrderContain::create([
                'order_id' => $orderID,
                'book_id' => $id,
            ]);

            // Re-calculate the order total price and total discount values
            if (!recalculateOrderValue($orderID)) {
                throw new Exception('Failed to recalculate order.');
            }
        });

        return 0;
    }

    public function showDetail(Request $request)
    {
        $book = $this->getBook($request->id);
        if (!$book) {
            abort(404);
        }
        return view('customer.book.detail', ['book' => refineBookData($book)]);
    }
}
