<?php

namespace App\Livewire\Customer\Home;

use Livewire\Component;
use App\Http\Controllers\Customer\Home;

class TopPublishers extends Component
{
    public $topPublishers = [];
    public $selectedPublisher = '';
    public $books = [];

    public function selectPublisher($publisher)
    {
        $this->selectedPublisher = $publisher;
        $this->getBooks();
    }

    private function getBooks()
    {
        $this->books = (new Home)->getPublisherBooks($this->selectedPublisher);
    }

    public function mount()
    {
        $this->topPublishers = (new Home)->getTopPublishers();
        $this->selectedPublisher = $this->topPublishers[0];
        $this->getBooks();
    }

    public function render()
    {
        return view('livewire.customer.home.top-publishers');
    }
}
