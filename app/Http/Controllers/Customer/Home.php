<?php

namespace App\Http\Controllers\Customer;

use App\Models\Book;
use App\Models\Order;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class Home extends Controller
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

    private function getDiscountBooks()
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

        if (count($discountedBooks) < 15) {
            $moreBooks = array_diff($temp, $discountedBooks);
            $moreBooks = array_slice($moreBooks, 0, 15 - count($discountedBooks), true);
            $discountedBooks = array_merge($discountedBooks, $moreBooks);
        }

        $temp = $discountedBooks;
        $discountedBooks = [];
        foreach ($temp as $id) {
            $discountedBooks[] = refineBookData(Book::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])->find($id));
        }

        return $discountedBooks;
    }

    private function getBestSellers()
    {
        $bookSales = $this->getBestBooksInWeek();
        $bookIDs = array_keys($bookSales);
        $bookIDs = array_slice($bookIDs, 0, 5, true);

        $books = [];
        foreach ($bookIDs as $id) {
            $books[] = refineBookData(Book::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])->find($id));
        }

        return $books;
    }

    public function getCategoryBooks($category)
    {
        $bookSales = $this->getBestBooksInWeek();
        $bookIDs = array_keys($bookSales);

        $books = [];

        foreach ($bookIDs as $id) {
            if (Book::where([
                ['id', '=', $id]
            ])->whereHas('categories', function (Builder $query) use ($category) {
                $query->where([
                    ['name', '=', $category]
                ]);
            })->first())
                $books[] = $id;
        }

        if (count($books) < 10) {
            $moreBooks = Book::whereHas('categories', function (Builder $query) use ($category) {
                $query->where([
                    ['name', '=', $category]
                ]);
            })->whereNotIn('id', $books)->limit(10 - count($books))->get();

            foreach ($moreBooks as $book) {
                $books[] = $book->id;
            }
        }

        $result = [];

        foreach ($books as $id) {
            $result[] = refineBookData(Book::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])->find($id));
        }

        return $result;
    }

    public function getPublisherBooks($publisher)
    {
        $bookSales = $this->getBestBooksInWeek();
        $bookIDs = array_keys($bookSales);

        $books = [];

        foreach ($bookIDs as $id) {
            if (Book::where([
                ['publisher', '=', $publisher],
                ['id', '=', $id]
            ])->first())
                $books[] = $id;
        }

        if (count($books) < 10) {
            $moreBooks = Book::where([
                ['publisher', '=', $publisher]
            ])->whereNotIn('id', $books)->limit(10 - count($books))->get();

            foreach ($moreBooks as $book) {
                $books[] = $book->id;
            }
        }

        $result = [];

        foreach ($books as $id) {
            $result[] = refineBookData(Book::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])->find($id));
        }

        return $result;
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

        return $publisherNames;
    }


    public function show()
    {
        return view('customer.index', [
            'discountedBooks' => $this->getDiscountBooks(),
            'bestSellingBooks' => $this->getBestSellers(),
        ]);
    }
}
