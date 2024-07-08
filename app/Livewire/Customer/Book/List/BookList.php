<?php

namespace App\Livewire\Customer\Book\List;

use Livewire\Component;
use Livewire\Attributes\On;

class BookList extends Component
{
    public $selectedCategory;
    public $selectedPublisher;
    public $selectedAuthor;

    #[On('select-publisher')]
    public function selectPublisher($selectedPublisher)
    {
        $this->selectedPublisher = $selectedPublisher;
    }

    #[On('select-category')]
    public function selectCategory($selectedCategory)
    {
        $this->selectedCategory = $selectedCategory;
    }

    #[On('search-author')]
    public function searchAuthor($selectedAuthor)
    {
        $this->selectedAuthor = $selectedAuthor;
    }

    public function mount()
    {
        $this->selectedCategory = '';
        $this->selectedPublisher = '';
        $this->selectedAuthor = '';
    }

    public function render()
    {
        return view('livewire.customer.book.list.book-list');
    }
}
