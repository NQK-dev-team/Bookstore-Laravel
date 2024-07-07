<?php

namespace App\Livewire\Customer\Home;

use Livewire\Component;
use App\Http\Controllers\Customer\Home;

class TopCategories extends Component
{
    public $topCategories = [];
    public $selectedCategory = '';
    public $books = [];

    public function selectCategory($category)
    {
        $this->selectedCategory = $category;
        $this->getBooks();
    }

    public function getBooks()
    {
        $this->books = (new Home)->getCategoryBooks($this->selectedCategory);
    }

    public function mount()
    {
        $this->topCategories = (new Home)->getTopCategories();
        $this->selectedCategory = $this->topCategories[0];
        $this->getBooks();
    }

    public function render()
    {
        return view('livewire.customer.home.top-categories');
    }
}
