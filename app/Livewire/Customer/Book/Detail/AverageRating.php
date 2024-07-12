<?php

namespace App\Livewire\Customer\Book\Detail;

use App\Models\Book;
use Livewire\Component;
use Livewire\Attributes\On;

class AverageRating extends Component
{
    public $book_id;
    public $rating;

    #[On('refresh-rating')]
    public function refreshAverageRating()
    {
        $book = Book::find($this->book_id);
        $this->rating = $book->average_rating;
    }

    public function mount()
    {
        $this->book_id = request()->id;
        $book = Book::find($this->book_id);
        $this->rating = $book->average_rating;
    }

    public function render()
    {
        return view('livewire.customer.book.detail.average-rating');
    }
}
