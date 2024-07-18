<?php

namespace App\Livewire\Customer\Book\Detail;

use App\Http\Controllers\Customer\Book\BookDetail;
use Livewire\Component;

class BookCart extends Component
{
    public $stock;
    public $physicalPrice;
    public $filePrice;
    public $discount;
    public $book_id;
    public $quantity;

    private $controller;

    public function __construct()
    {
        $this->controller = new BookDetail;
    }

    public function refetchStock()
    {
        $book = $this->controller->getBook($this->book_id);
        $this->stock = $book->physicalCopy ? ($book->physicalCopy->quantity) : null;
        $this->checkAmount();
    }

    public function decreaseAmount()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function increaseAmount()
    {
        if ($this->quantity < $this->stock) {
            $this->quantity++;
        }
    }

    public function checkAmount()
    {
        if ($this->quantity < 1) {
            $this->quantity = 1;
        }

        if ($this->quantity > $this->stock) {
            $this->quantity = $this->stock;
        }
    }

    public function addToCart($option)
    {
        $failed = false;
        $bought = false;
        $inCart = false;
        if ($option === 0) {
            $failed = true;
        } else if ($option === 1) {
            $result = $this->controller->addPhysicalToCart($this->book_id, $this->quantity);
        } else if ($option === 2) {
            $result = $this->controller->addFileToCart($this->book_id);

            if ($result === 1)
                $bought = true;
            else if ($result === 2)
                $inCart = true;
        }

        if ($failed) {
            $this->dispatch('cart-error');
            return;
        }

        if ($bought) {
            $this->dispatch('notice-bought');
            return;
        }

        if ($inCart) {
            $this->dispatch('notice-in-cart');
            return;
        }

        if ($option === 1)
            $this->dispatch('notice-add-to-cart-1');
        else if ($option === 2)
            $this->dispatch('notice-add-to-cart-2');
    }

    public function mount()
    {
        $this->book_id = request()->id;
        $book = $this->controller->getBook($this->book_id);
        $this->physicalPrice = $book->physicalCopy ? ($book->physicalCopy->price) : null;
        $this->stock = $book->physicalCopy ? ($book->physicalCopy->quantity) : null;
        $this->filePrice = $book->fileCopy ? ($book->fileCopy->price) : null;
        $temp = getBookBestDiscount($book);
        $this->discount = $temp ? $temp->discount : null;
        $this->quantity = $this->stock ? 1 : 0;
    }

    public function render()
    {
        return view('livewire.customer.book.detail.book-cart');
    }
}
