<?php

namespace App\Livewire\Customer\Book\List;

use App\Http\Controllers\Customer\Book\List\BookList;
use Livewire\Component;

class Category extends Component
{
    public $categories;
    public $category;
    public $selectedCategory;

    public function selectCategory($category)
    {
        if ($category === $this->selectedCategory)
            $this->selectedCategory = '';
        else
            $this->selectedCategory = $category;

        $this->dispatch('select-category', selectedCategory: $this->selectedCategory);
    }

    public function searchCategory()
    {
        if ($this->category) {
            $this->categories = [];
            $temp = (new BookList)->searchCategory($this->category);
            foreach ($temp as $elem) {
                $this->categories[] = $elem->name;
            }
        } else
            $this->categories = (new BookList)->getTopCategories();
    }

    public function mount()
    {
        $this->categories = (new BookList)->getTopCategories();
        $this->selectedCategory = '';
    }

    public function render()
    {
        return view('livewire.customer.book.list.category');
    }
}
