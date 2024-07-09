<?php

namespace App\Livewire\Customer\Book\List;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\Customer\Book\List\BookList;

class Author extends Component
{
    public $author;
    public $authors;
    public $selectedAuthor;

    #[On('select-author')]
    public function selectAuthor($author, $called = false)
    {
        if ($author === $this->selectedAuthor)
            $this->selectedAuthor = '';
        else
            $this->selectedAuthor = $author;

        if (!$called)
            $this->dispatch('select-author-modal', author: $this->selectedAuthor, called: true);
        else
            $this->dispatch('search-book');
    }

    public function searchAuthor()
    {
        if ($this->author) {
            $this->authors = [];
            $temp = (new BookList)->searchAuthor($this->author);
            foreach ($temp as $elem) {
                $this->authors[] = $elem->name;
            }
        } else
            $this->authors = (new BookList)->getTopAuthors();
    }

    public function __construct()
    {
        $this->authors = (new BookList)->getTopAuthors();
        $this->selectedAuthor = '';
    }

    public function render()
    {
        return view('livewire.customer.book.list.author');
    }
}
