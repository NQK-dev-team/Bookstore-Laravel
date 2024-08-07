<?php

namespace App\Http\Controllers\Customer\Book;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Order;
use App\Models\Author;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class BookList extends Controller
{
    private function getBestBooksInWeek()
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

    private function getDiscountBooks($author, $category, $publisher, $bookParam)
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
                return array_slice($this->getDiscountBooks($author, $category, $publisher, $book), $offset * $limit, $limit);
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

    public function show()
    {
        return view('customer.book.index');
    }
}
