<?php

namespace App\Livewire\Admin\Manage\Book;

use Livewire\Component;
use App\Http\Controllers\Admin\Manage\Book;

class Publisher extends Component
{
    private $controller;
    public $search;
    public $publishers;
    public $selectedPublisher;
    public $breakpoint;

    public function __construct()
    {
        $this->controller = new Book();
        $this->search = null;
        $this->selectedPublisher = null;
        $this->searchPublishers();
    }

    public function searchPublishers()
    {
        $this->publishers = $this->controller->getPublisher($this->search);
    }

    public function setPublisher($publisher)
    {
        if ($this->selectedPublisher === $publisher)
            $this->selectedPublisher = null;
        else
            $this->selectedPublisher = $publisher;
        $this->publishers = $this->controller->getPublisher($this->selectedPublisher);
        $this->search = $this->selectedPublisher;
        $this->dispatch('select-publisher', $this->selectedPublisher);
    }

    public function render()
    {
        return view('livewire.admin.manage.book.publisher');
    }
}
