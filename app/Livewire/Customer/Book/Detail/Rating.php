<?php

namespace App\Livewire\Customer\Book\Detail;

use App\Models\Book;
use Livewire\Component;
use App\Http\Controllers\Customer\Book\BookDetail;

class Rating extends Component
{
    public $book_id;
    public $average_rating;
    public $isBought;
    public $hasRated;
    public $comment;

    public $rating;
    public $ratings;
    public $ratingFilter;
    public $isRatingExist;
    public $numberOfRatingsShown;

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
        $this->fetchRating();
    }

    public function fetchRating()
    {
        $this->isRatingExist = (new BookDetail)->isRatingExist($this->book_id);
        $this->ratings = (new BookDetail)->getRatings($this->book_id, $this->numberOfRatingsShown, $this->ratingFilter);
    }

    public function loadMoreRatings()
    {
        $this->numberOfRatingsShown += 20;
        $this->fetchRating();
    }

    public function submitRating()
    {
        $this->validate([
            'rating' => 'gte:1|lte:5',
        ], [
            'rating.gte' => 'Please rate the book.',
            'rating.lte' => 'Star value invalid.',
        ]);
        (new BookDetail)->submitRating($this->book_id, $this->rating, $this->comment);
        $this->dispatch('refresh-rating');
        $this->hasRated = true;
    }

    public function deleteRating()
    {
        (new BookDetail)->deleteRating($this->book_id);
        $this->dispatch('refresh-rating');
        $this->hasRated = false;
        $this->rating = 0;
        $this->comment = '';
        $this->resetErrorBag();
    }

    public function mount()
    {
        $this->book_id = request()->id;
        $book = Book::find($this->book_id);
        $this->average_rating = $book->average_rating;
        $this->isBought = (new BookDetail)->checkCustomerBoughtBook($this->book_id);
        $this->getCustomerRating();
        $this->numberOfRatingsShown = 20;
        $this->fetchRating();
        $this->ratingFilter = '';
    }

    public function render()
    {
        $this->refreshAverageRating();
        return view('livewire.customer.book.detail.rating');
    }
}
