<?php

namespace App\Livewire\Admin\Manage\Book;

use Livewire\Component;
use App\Http\Controllers\Admin\Manage\Book;

class Category extends Component
{
    private $controller;
    public $search;
    public $categories;

    public function __construct()
    {
        $this->controller = new Book();
        $this->search = null;
    }

    public function render()
    {
        $this->categories = $this->controller->getCategory($this->search);
        return view('livewire.admin.manage.book.category');
    }
}
