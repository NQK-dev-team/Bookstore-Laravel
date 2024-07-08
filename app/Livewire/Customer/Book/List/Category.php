<?php

namespace App\Livewire\Customer\Book\List;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\Customer\Book\List\BookList;

class Category extends Component
{
    public $categories;
    public $category;
    public $selectedCategory;

    #[On('select-category')]
    public function selectCategory($category, $called = false)
    {
        if ($category === $this->selectedCategory)
            $this->selectedCategory = '';
        else
            $this->selectedCategory = $category;

        if (!$called)
            $this->dispatch('select-category-modal', category: $this->selectedCategory, called: true);
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
