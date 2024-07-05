<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;

class Home extends Controller
{
    public function getDiscountBooks()
    {
        // $orders = Order::where([
        //     ['status', '=', true]
        // ])->whereRaw("DATE_PART('week', updated_at) = ?", [date('W')])->get();

        // $discountBooks = [];

        // foreach ($orders as $order) {
        //     if ($physicalOrder = $order->physicalOrder) {
        //         foreach ($physicalOrder->physicalCopies as $physicalCopy) {
        //             if (isset($discountBooks[$physicalCopy->id])) {
        //                 $discountBooks[$physicalCopy->id] += $physicalCopy->pivot->amount;
        //             } else {
        //                 $discountBooks[$physicalCopy->id] = $physicalCopy->pivot->amount;
        //             }
        //         }
        //     }

        //     if ($fileOrder = $order->fileOrder) {
        //         foreach ($fileOrder->fileCopies as $fileCopy) {
        //             if (isset($discountBooks[$fileCopy->id])) {
        //                 $discountBooks[$fileCopy->id]++;
        //             } else {
        //                 $discountBooks[$fileCopy->id] = 1;
        //             }
        //         }
        //     }
        // }

        // return $discountBooks;
    }

    public static function getCategoryBooks($category)
    {
    }

    public static function getPublisherBooks($publisher)
    {
    }

    public static function getTopCategories()
    {
        $orders = Order::where([
            ['status', '=', true]
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
        $bookIDs = array_keys($bookSales);

        $books = Book::whereIn('id', $bookIDs)->get();
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

    public static function getTopPublishers()
    {
        $orders = Order::where([
            ['status', '=', true]
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
            'discountBooks' => $this->getDiscountBooks(),
        ]);
    }
}
