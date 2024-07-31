<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Models\Book as BookModel;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;

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

    public function getBook( $category = null, $author = null, $publisher = null, $book = null, $offset = 0, $limit = 10)
    {
        return BookModel::with(['physicalCopy', 'fileCopy', 'categories', 'authors'])->whereHas('authors', function ($query) use ($author) {
            $query->where('name', 'like', $author);
        })->whereHas('categories', function ($query) use ($category) {
            $query->where('name', 'like', $category);
        })->where([
            ['name', 'ilike', '%' . $book . '%'],
            ['publisher', 'like', $publisher],
            ['status', '=', true],
        ])->offset($offset * $limit)->limit($limit)->get();
    }

    public function show()
    {
        return view('admin.manage.book.index');
    }
}
