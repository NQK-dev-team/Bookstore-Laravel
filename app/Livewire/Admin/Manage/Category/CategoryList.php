<?php

namespace App\Livewire\Admin\Manage\Category;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\Admin\Manage\Category;
use Livewire\Attributes\Renderless;

class CategoryList extends Component
{
    public $categories;
    public $limit;
    public $offset;
    public $search;
    public $total;
    public $selectedCategory;
    private $controller;

    public function __construct()
    {
        $this->controller = new Category();
        $this->search = null;
        $this->selectedCategory = null;
        $this->limit = 10;
        $this->offset = 0;
    }

    public function searchCategory($search)
    {
        $this->search = $search;
        $this->resetPagination();
    }

    public function previous()
    {
        if (!($this->offset <= 0))
            $this->offset--;
    }

    public function next()
    {
        if (!(($this->offset + 1) * $this->limit >= $this->total))
            $this->offset++;
    }

    public function resetPagination()
    {
        $this->offset = 0;
    }

    #[On('reset-category-id')]
    public function resetCategorySelection()
    {
        $this->selectedCategory = null;
        $this->dispatch('set-category-form-fields', selectedCategory: null, categoryName: null, categoryDescription: null);
    }


    public function deleteCategory()
    {
        $this->controller->deleteCategory($this->selectedCategory);
    }

    #[Renderless]
    public function openUpdateModal($categoryID)
    {
        $this->selectedCategory = $categoryID;
        $category = $this->categories->where('id', $categoryID)->first();
        $this->dispatch('set-category-form-fields', selectedCategory: $this->selectedCategory, categoryName: $category->name, categoryDescription: $category->description);
    }

    public function render()
    {
        $this->total = $this->controller->getTotalCategories($this->search) ?? 0;
        $this->categories = $this->controller->getCategories($this->search, $this->limit, $this->offset) ?? [];
        return view('livewire.admin.manage.category.category-list');
    }
}
