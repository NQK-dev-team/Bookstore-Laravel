<?php

namespace App\Livewire\Admin\Manage\Book;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\Admin\Manage\Book;

class BookList extends Component
{
    public $author;
    public $category;
    public $publisher;
    public $search;
    public $offset;
    public $limit;
    public $books;
    private $controller;

    public function __construct()
    {
        $this->author = null;
        $this->category = null;
        $this->publisher = null;
        $this->search = null;
        $this->offset = 0;
        $this->limit = 10;
        $this->controller = new Book();
    }

    #[On('select-author')]
    public function selectAuthor($author)
    {
        $this->author = $author;
    }

    #[On('select-category')]
    public function selectCategory($category)
    {
        $this->category = $category;
    }

    #[On('select-publisher')]
    public function selectPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    #[On('select-limit')]
    public function selectLimit($limit)
    {
        $this->limit = $limit;
    }

    #[On('search-book')]
    public function searchBook($search)
    {
        $this->search = ($search === '' || !$search) ? null : $search;
    }

    public function render()
    {
        return view('livewire.admin.manage.book.book-list');
    }
}
