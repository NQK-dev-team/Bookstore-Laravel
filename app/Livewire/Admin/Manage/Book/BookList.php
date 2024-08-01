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
    public $status;
    public $total;
    private $controller;

    public function __construct()
    {
        $this->author = null;
        $this->category = null;
        $this->publisher = null;
        $this->search = null;
        $this->offset = 0;
        $this->limit = 10;
        $this->status = true;
        $this->controller = new Book();
    }

    #[On('select-author')]
    public function selectAuthor($author)
    {
        $this->author = $author;
        $this->resetPagination();
    }

    #[On('select-category')]
    public function selectCategory($category)
    {
        $this->category = $category;
        $this->resetPagination();
    }

    #[On('select-publisher')]
    public function selectPublisher($publisher)
    {
        $this->publisher = $publisher;
        $this->resetPagination();
    }

    public function searchBook($search)
    {
        $this->search = ($search === '' || !$search) ? null : $search;
    }

    public function previous()
    {
        if (!($this->offset <= 0))
            $this->offset--;
    }

    public function next()
    {
        if (!(($this->offset + 1) * $this->limit >= $this->total))
            $this->offset++;
    }

    public function resetPagination()
    {
        $this->offset = 0;
    }

    public function render()
    {
        $this->total = $this->controller->getTotal($this->category, $this->author, $this->publisher, $this->search, $this->status);
        $this->books = $this->controller->getBook($this->category, $this->author, $this->publisher, $this->search, $this->status, $this->offset, $this->limit);
        foreach ($this->books as &$book) {
            refineBookData($book, false);
        }
        return view('livewire.admin.manage.book.book-list');
    }
}
