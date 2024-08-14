<?php

namespace App\Livewire\Customer\Book\Detail;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\Customer\Book\BookController;

class AverageRating extends Component
{
    public $book_id;
    public $rating;
    private $controller;

    public function __construct()
    {
        $this->controller = new BookController();
    }

    #[On('refresh-rating')]
    public function refreshAverageRating()
    {
        // $book = Book::find($this->book_id);
        $book = $this->controller->getBook($this->book_id);
        $this->rating = $book->average_rating;
    }

    public function mount()
    {
        $this->book_id = request()->id;
        // $book = Book::find($this->book_id);
        $book = $this->controller->getBook($this->book_id);
        $this->rating = $book->average_rating;
    }

    public function render()
    {
        return view('livewire.customer.book.detail.average-rating');
    }
}
