<?php

namespace App\Livewire\Customer\Home;

use Livewire\Component;
use App\Http\Controllers\Customer\Home\Home;

class TopPublishers extends Component
{
    public $topPublishers = [];
    public $selectedPublisher = '';
    public $books = [];
    private $controller;

    public function __construct()
    {
        $this->controller = new Home();
    }

    public function selectPublisher($publisher)
    {
        $this->selectedPublisher = $publisher;
        $this->getBooks();
    }

    private function getBooks()
    {
        $this->books = $this->controller->getPublisherBooks($this->selectedPublisher);
    }

    public function mount()
    {
        $this->topPublishers = $this->controller->getTopPublishers();
        $this->selectedPublisher = $this->topPublishers ? $this->topPublishers[0] : null;
        $this->getBooks();
    }

    public function render()
    {
        return view('livewire.customer.home.top-publishers');
    }
}
