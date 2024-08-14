<?php

namespace App\Http\Controllers\Customer\Home;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Discount;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Customer\Book\BookController;

class Home extends Controller
{
    private $bookController;

    public function __construct()
    {
        $this->bookController = new BookController();
    }

    public function getBestSellers()
    {
        $bookSales = $this->bookController->getBestBooksInWeek();
        $bookIDs = array_keys($bookSales);
        $bookIDs = array_slice($bookIDs, 0, 5, true);

        $books = [];
        foreach ($bookIDs as $id) {
            $books[] = refineBookData(Book::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])->where('status', true)->find($id));
        }

        return $books;
    }

    public function getCategoryBooks($category)
    {
        $bookSales = $this->bookController->getBestBooksInWeek();
        $bookIDs = array_keys($bookSales);

        $books = [];

        foreach ($bookIDs as $id) {
            if (Book::where([
                ['id', '=', $id]
            ])->whereHas('categories', function (Builder $query) use ($category) {
                $query->where([
                    ['name', '=', $category]
                ]);
            })->where('status', true)->first())
                $books[] = $id;
        }

        if (count($books) < 10) {
            $moreBooks = Book::whereHas('categories', function (Builder $query) use ($category) {
                $query->where([
                    ['name', '=', $category]
                ]);
            })->whereNotIn('id', $books)->where('status', true)->limit(10 - count($books))->get();

            foreach ($moreBooks as $book) {
                $books[] = $book->id;
            }
        }

        $result = [];

        foreach ($books as $id) {
            $result[] = refineBookData(Book::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])->where('status', true)->find($id));
        }

        return $result;
    }

    public function getPublisherBooks($publisher)
    {
        $bookSales = $this->bookController->getBestBooksInWeek();
        $bookIDs = array_keys($bookSales);

        $books = [];

        foreach ($bookIDs as $id) {
            if (Book::where([
                ['publisher', '=', $publisher],
                ['id', '=', $id],
                ['status', '=', true],
            ])->first())
                $books[] = $id;
        }

        if (count($books) < 10) {
            $moreBooks = Book::where([
                ['publisher', '=', $publisher]
            ])->where('status', true)->whereNotIn('id', $books)->limit(10 - count($books))->get();

            foreach ($moreBooks as $book) {
                $books[] = $book->id;
            }
        }

        $result = [];

        foreach ($books as $id) {
            $result[] = refineBookData(Book::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])->where('status', true)->find($id));
        }

        return $result;
    }

    public function getTopCategories()
    {
        $bookSales = $this->bookController->getBestBooksInWeek();
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

        return $categoryNames;
    }

    public function getTopPublishers()
    {
        $bookSales = $this->bookController->getBestBooksInWeek();
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

        return $publisherNames;
    }

    public function show()
    {
        return view('customer.home.index', [
            'discountedBooks' => $this->bookController->getDiscountBooks(),
            'bestSellingBooks' => $this->getBestSellers(),
        ]);
    }
}
