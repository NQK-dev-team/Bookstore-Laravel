<?php

namespace App\Livewire\Admin\Manage\Book;

use Livewire\Component;
use App\Http\Controllers\Admin\Manage\Book;

class Category extends Component
{
    private $controller;
    public $search;
    public $categories;
    public $selectedCategory;

    public function __construct()
    {
        $this->controller = new Book();
        $this->search = null;
        $this->selectedCategory = null;
        $this->searchCategories();
    }

    public function searchCategories()
    {
        $this->categories = $this->controller->getCategory($this->search);
    }

    public function setCategory($category)
    {
        if ($this->selectedCategory === $category)
            $this->selectedCategory = null;
        else
            $this->selectedCategory = $category;
        $this->categories = $this->controller->getCategory($this->selectedCategory);
        $this->search = $this->selectedCategory;
        $this->dispatch('select-category', $this->selectedCategory);
    }

    public function render()
    {
        return view('livewire.admin.manage.book.category');
    }
}
