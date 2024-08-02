<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Models\Order;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Book as BookModel;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class Book extends Controller
{
    public function getCategory($category = null)
    {
        if (!$category)
            return Category::get();

        return Category::where('name', 'ilike', "%{$category}%")->get();
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

    public function getBook($category = null, $author = null, $publisher = null, $search = null, $status = true, $offset = 0, $limit = 10)
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

    public function show()
    {
        return view('admin.manage.book.index');
    }
}
