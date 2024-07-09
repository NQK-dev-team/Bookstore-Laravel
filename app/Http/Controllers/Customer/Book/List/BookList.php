<?php

namespace App\Http\Controllers\Customer\Book\List;

use App\Models\Book;
use App\Models\Order;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function searchBook($author, $category, $publisher, $book, $offset, $limit)
    {
    }

    public function show()
    {
        return view('customer.book.index');
    }
}
