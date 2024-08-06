<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Models\Category as CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Category extends Controller
{
    public function getCategories($search, $limit, $offset)
    {
        if (!$search)
            $search = '';
        return CategoryModel::where('name', 'ilike', '%' . $search . '%')
            ->limit($limit)
            ->offset($offset * $limit)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getTotalCategories($search)
    {
        if (!$search)
            $search = '';
        return CategoryModel::where('name', 'ilike', '%' . $search . '%')->count();
        // return CategoryModel::count();
    }

    public function updateCategory($categoryID, $categoryName, $categoryDescription)
    {
        DB::transaction(function () use ($categoryID, $categoryName, $categoryDescription) {
            $category = CategoryModel::find($categoryID);
            $category->name = $categoryName;
            $category->description = $categoryDescription;
            $category->save();
        });
    }

    public function createCategory($categoryName, $categoryDescription)
    {
        DB::transaction(function () use ($categoryName, $categoryDescription) {
            $category = new CategoryModel();
            $category->id = IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']);
            $category->name = $categoryName;
            $category->description = $categoryDescription;
            $category->save();
        });
    }

    public function deleteCategory($categoryID)
    {
        DB::transaction(function () use ($categoryID) {
            $category = CategoryModel::find($categoryID);
            $category->delete();
        });
    }

    public function show()
    {
        return view('admin.manage.category.index');
    }
}
