<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Models\Category as CategoryModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Category extends Controller
{
    public function searchCategory($category = null)
    {
        if (!$category)
            return CategoryModel::get();
        else
            $category = trim($category);

        return CategoryModel::where('name', 'ilike', "%{$category}%")->get();
    }

    // public function getCategoryByIds($ids)
    // {
    //     return CategoryModel::whereIn('id', $ids)->get();
    // }

    public function getCategories($search, $limit, $offset)
    {
        if (!$search)
            $search = '';
        else
            $search = trim($search);
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
        else
            $search = trim($search);
        return CategoryModel::where('name', 'ilike', '%' . $search . '%')->count();
        // return CategoryModel::count();
    }

    public function updateCategory($categoryID, $categoryName, $categoryDescription)
    {
        DB::transaction(function () use ($categoryID, $categoryName, $categoryDescription) {
            $category = CategoryModel::find($categoryID);
            $category->name = trim($categoryName);
            $category->description = trim($categoryDescription);
            $category->save();
        });
    }

    public function createCategory($categoryName, $categoryDescription)
    {
        DB::transaction(function () use ($categoryName, $categoryDescription) {
            $category = new CategoryModel();
            $category->id = IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']);
            $category->name = trim($categoryName);
            $category->description = trim($categoryDescription);
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
