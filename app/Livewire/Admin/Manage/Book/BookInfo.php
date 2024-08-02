<?php

namespace App\Livewire\Admin\Manage\Book;

use App\Http\Controllers\Admin\Manage\Book;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class BookInfo extends Component
{

    #[Reactive]
    public $bookID;
    #[Reactive]
    public $openInfoModal;
    public $bookName;
    public $bookEdition;
    public $bookIsbn;
    public $bookAuthors;
    public $bookCategories;
    public $bookPublisher;
    public $bookPublicationDate;
    public $bookDescription;
    public $physicalPrice;
    public $physicalQuantity;
    public $filePrice;
    public $filePath;
    public $bookImage;
    private $controller;

    public function mount()
    {
        $this->controller = new Book();
    }

    public function getBookInfo()
    {
        $book = $this->controller->getBookInfo($this->bookID);
    }

    public function render()
    {
        if ($this->bookID)
            $this->getBookInfo();
        return view('livewire.admin.manage.book.book-info');
    }
}
