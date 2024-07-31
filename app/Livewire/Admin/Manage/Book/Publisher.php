<?php

namespace App\Livewire\Admin\Manage\Book;

use Livewire\Component;
use App\Http\Controllers\Admin\Manage\Book;

class Publisher extends Component
{
    private $controller;
    public $search;
    public $publishers;

    public function __construct()
    {
        $this->controller = new Book();
        $this->search = null;
    }

    public function render()
    {
        $this->publishers = $this->controller->getPublisher($this->search);
        return view('livewire.admin.manage.book.publisher');
    }
}
