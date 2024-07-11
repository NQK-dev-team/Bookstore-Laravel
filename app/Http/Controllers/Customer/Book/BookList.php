<?php

namespace App\Http\Controllers\Customer\Book;

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
                    if (isset($bookSales[$physicalCopy->id])) {
                        $bookSales[$physicalCopy->id] += $physicalCopy->pivot->amount;
                    } else {
                        $bookSales[$physicalCopy->id] = $physicalCopy->pivot->amount;
                    }
                }
            }

            if ($fileOrder = $order->fileOrder) {
                foreach ($fileOrder->fileCopies as $fileCopy) {
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
                ['start_date', '<=', date('Y-m-d')],
                ['end_date', '>=', date('Y-m-d')],
            ]);
        })->orderBy('discount', 'desc')->first();

        if (!$discounts) {
            $discounts = Discount::with([
                "eventDiscount" => ["booksApplied"],
            ])->whereHas('eventDiscount', function (Builder $query) {
                $query->where([
                    ['apply_for_all_books', '=', false],
                    ['start_date', '<=', date('Y-m-d')],
                    ['end_date', '>=', date('Y-m-d')],
                ]);
            })->orderBy('discount', 'desc')->get();

            if (!$discounts) return [];
            else {
                foreach ($discounts as $discount) {
                    $books = $discount->eventDiscount->booksApplied;
                    foreach ($books as $book) {
                        if (!in_array($book, $discountedBooks))
                            $discountedBooks[] = $book->id;
                    }
                }
            }
        } else {
            $books = Book::all();
            foreach ($books as $book) {
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
                    ['name', 'ilike', '%' . $bookParam . '%'],
                    ['publisher', 'like', $publisher],
                ])->first();
        }

        return $discountedBooks;
    }

    public function getTopCategories()
    {
        $bookSales = $this->getBestBooksInWeek();
        $bookIDs = array_keys($bookSales);

        $books = Book::with("categories")->whereIn('id', $bookIDs)->get();
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

        $books = Book::whereIn('id', $bookIDs)->get();
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
            $publishers = Book::select('publisher')->whereNotIn('publisher', $publisherNames)->limit(5 - count($publisherNames))->distinct()->get();
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

        $books = Book::with("authors")->whereIn('id', $bookIDs)->get();
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
        return Category::select('name')->where('name', 'like', '%' . $category . '%')->distinct()->get();
    }

    public function searchPublisher($publisher)
    {
        return Book::select('publisher')->where('publisher', 'like', '%' . $publisher . '%')->distinct()->get();
    }

    public function searchAuthor($author)
    {
        return Author::select('name')->where('name', 'like', '%' . $author . '%')->distinct()->get();
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
                    ['name', 'ilike', '%' . $book . '%'],
                    ['publisher', 'like',  $publisher],
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
                                ['name', 'ilike', '%' . $book . '%'],
                                ['publisher', 'like', $publisher],
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
                        ['name', 'ilike', '%' . $book . '%'],
                        ['publisher', 'like',  $publisher],
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
                        ['name', 'ilike', '%' . $book . '%'],
                        ['publisher', 'like', '%' . $publisher . '%'],
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
