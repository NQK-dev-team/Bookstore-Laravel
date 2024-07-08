<?php

namespace App\Livewire\Customer\Book\List;

use Livewire\Component;
use App\Http\Controllers\Customer\Book\List\BookList;

class Author extends Component
{
    public $author;
    public $authors;
    public $selectedAuthor;

    public function selectAuthor($author)
    {
        if ($author === $this->selectedAuthor)
            $this->selectedAuthor = '';
        else
            $this->selectedAuthor = $author;

        $this->dispatch('select-author', selectedAuthor: $this->selectedAuthor);
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

    public function mount()
    {
        $this->authors = (new BookList)->getTopAuthors();
        $this->selectedAuthor = '';
    }

    public function render()
    {
        return view('livewire.customer.book.list.author');
    }
}
