<?php

namespace App\Livewire\Customer\Book\Detail;

use App\Http\Controllers\Customer\Book\BookDetail;
use App\Models\Book;
use Livewire\Component;

class Rating extends Component
{
    public $average_rating;
    public $isBought;
    public $hasRated;
    public $comment;

    public function refreshAverageRating()
    {
        $book = Book::find(request()->id);
        $this->average_rating = $book->average_rating;
    }

    public function mount()
    {
        $book = Book::find(request()->id);
        $this->average_rating = $book->average_rating;
        $this->isBought = (new BookDetail)->checkCustomerBoughtBook(request()->id);
        $this->hasRated = (new BookDetail)->checkCustomerRateBook(request()->id);
    }

    public function render()
    {
        return view('livewire.customer.book.detail.rating');
    }
}
