<?php

namespace App\Livewire\Customer\Home;

use Livewire\Component;
use App\Http\Controllers\Customer\Home\Home;

class TopCategories extends Component
{
    public $topCategories = [];
    public $selectedCategory = '';
    public $books = [];
    private $controller;

    public function __construct()
    {
        $this->controller = new Home();
    }

    public function selectCategory($category)
    {
        $this->selectedCategory = $category;
        $this->getBooks();
    }

    public function getBooks()
    {
        $this->books = $this->controller->getCategoryBooks($this->selectedCategory);
    }

    public function mount()
    {
        $this->topCategories = $this->controller->getTopCategories();
        $this->selectedCategory = $this->topCategories ? $this->topCategories[0] : null;
        $this->getBooks();
    }

    public function render()
    {
        return view('livewire.customer.home.top-categories');
    }
}
