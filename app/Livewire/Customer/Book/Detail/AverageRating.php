<?php

namespace App\Livewire\Customer\Book\Detail;

use App\Models\Book;
use Livewire\Component;
use Livewire\Attributes\On;

class AverageRating extends Component
{
    public $rating;

    #[On('refresh-rating')]
    public function refreshAverageRating()
    {
        $book = Book::find(request()->id);
        $this->rating = $book->average_rating;
    }

    public function mount()
    {
        $book = Book::find(request()->id);
        $this->rating = $book->average_rating;
    }

    public function render()
    {
        return view('livewire.customer.book.detail.average-rating');
    }
}
