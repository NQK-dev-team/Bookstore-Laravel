<?php

namespace App\Livewire\Admin\Manage\Category;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\Admin\Manage\Category;
use Livewire\Attributes\Renderless;

class CategoryForm extends Component
{
    public $categoryName;
    public $categoryDescription;
    public $selectedCategory;
    private $controller;

    public function __construct()
    {
        $this->controller = new Category();
        $this->selectedCategory = null;
    }

    #[On('set-category-form-fields')]
    public function setFields($selectedCategory, $categoryName, $categoryDescription)
    {
        $this->categoryName = $categoryName;
        $this->categoryDescription = $categoryDescription;
        $this->selectedCategory = $selectedCategory;
        $this->resetErrorBag();
    }

    public function updateCategory()
    {
        $this->validate([
            'categoryName' => 'required|unique:categories,name,' . $this->selectedCategory,
            'categoryDescription' => 'required',
        ]);

        $this->controller->updateCategory($this->selectedCategory, $this->categoryName, $this->categoryDescription);
        $this->dispatch('dismiss-info-modal');
    }

    public function createCategory()
    {
        $this->validate([
            'categoryName' => 'required|unique:categories,name',
            'categoryDescription' => 'required',
        ]);

        $this->controller->createCategory($this->categoryName, $this->categoryDescription);
        $this->dispatch('dismiss-info-modal');
    }

    public function render()
    {
        return view('livewire.admin.manage.category.category-form');
    }
}
