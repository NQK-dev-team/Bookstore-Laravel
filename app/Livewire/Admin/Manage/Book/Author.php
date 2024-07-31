<?php

namespace App\Livewire\Admin\Manage\Book;

use App\Http\Controllers\Admin\Manage\Book;
use Livewire\Component;

class Author extends Component
{
    private $controller;
    public $search;
    public $authors;

    public function __construct()
    {
        $this->controller = new Book();
        $this->search = null;
    }

    public function render()
    {
        $this->authors = $this->controller->getAuthor($this->search);
        return view('livewire.admin.manage.book.author');
    }
}
