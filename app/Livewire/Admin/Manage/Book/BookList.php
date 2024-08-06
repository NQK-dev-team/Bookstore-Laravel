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
    public $bookID;
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
        $this->bookID = null;
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

    #[On('reset-book-id')]
    public function resetBookSelection()
    {
        $this->bookID = null;
    }

    public function reactivateBook()
    {
        if ($this->bookID) {
            $this->controller->reactivateBook($this->bookID);
        }
    }

    public function deactivateBook()
    {
        if ($this->bookID) {
            $this->controller->deactivateBook($this->bookID);
        }
    }

    public function deleteBook()
    {
        if ($this->bookID) {
            $this->controller->deleteBook($this->bookID);
        }
    }

    public function render()
    {
        $this->total = $this->controller->getTotal($this->category, $this->author, $this->publisher, $this->search, $this->status);
        $this->books = $this->controller->getBooks($this->category, $this->author, $this->publisher, $this->search, $this->status, $this->offset, $this->limit);
        foreach ($this->books as &$book) {
            refineBookData($book, false);
            $book->isBought = $this->controller->isBookBought($book->id);
        }
        return view('livewire.admin.manage.book.book-list');
    }
}
