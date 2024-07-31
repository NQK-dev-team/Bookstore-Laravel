<?php

namespace App\Livewire\Admin\Manage\Book;

use App\Http\Controllers\Admin\Manage\Book;
use Livewire\Component;

class Author extends Component
{
    private $controller;
    public $search;
    public $authors;
    public $selectedAuthor;

    public function __construct()
    {
        $this->controller = new Book();
        $this->search = null;
        $this->selectedAuthor = null;
        $this->searchAuthors();
    }

    public function searchAuthors()
    {
        $this->authors = $this->controller->getAuthor($this->search);
    }

    public function setAuthor($author)
    {
        if ($this->selectedAuthor === $author)
            $this->selectedAuthor = null;
        else
            $this->selectedAuthor = $author;
        $this->authors = $this->controller->getAuthor($this->selectedAuthor);
        $this->search = $this->selectedAuthor;
        $this->dispatch('select-author', $this->selectedAuthor);
    }

    public function render()
    {
        return view('livewire.admin.manage.book.author');
    }
}
