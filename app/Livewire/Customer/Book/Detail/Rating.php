<?php

namespace App\Livewire\Customer\Book\Detail;

use App\Http\Controllers\Customer\Book\BookDetail;
use App\Models\Book;
use Livewire\Component;

class Rating extends Component
{
    public $book_id;
    public $average_rating;
    public $isBought;
    public $hasRated;
    public $comment;
    public $rating;

    private function getCustomerRating()
    {
        $rating = (new BookDetail)->getCustomerRating($this->book_id);
        if ($rating) {
            $this->hasRated = true;
            $this->comment = $rating->comment;
            $this->rating = $rating->star;
        } else {
            $this->hasRated = false;
            $this->comment = '';
            $this->rating = 0;
        }
    }

    private function refreshAverageRating()
    {
        $book = Book::find($this->book_id);
        $this->average_rating = $book->average_rating;
    }

    public function submitRating()
    {
        (new BookDetail)->submitRating($this->book_id, $this->rating, $this->comment);
        $this->refreshAverageRating();
        $this->dispatch('refresh-rating');
        $this->hasRated = true;
    }

    public function deleteRating()
    {
        (new BookDetail)->deleteRating($this->book_id);
        $this->refreshAverageRating();
        $this->dispatch('refresh-rating');
        $this->hasRated = false;
        $this->rating = 0;
        $this->comment = '';
    }

    public function mount()
    {
        $this->book_id = request()->id;
        $book = Book::find($this->book_id);
        $this->average_rating = $book->average_rating;
        $this->isBought = (new BookDetail)->checkCustomerBoughtBook($this->book_id);
        $this->getCustomerRating();
    }

    public function render()
    {
        return view('livewire.customer.book.detail.rating');
    }
}
