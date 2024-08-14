<?php

namespace App\Livewire\Admin\Manage\Book;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\Admin\Manage\Category;

class CategoryModalBody extends Component
{
    public $categories;
    private $search;
    private $controller;
    public $preSelectedCategories;

    public function __construct()
    {
        $this->controller = new Category();
        $this->search = null;
    }

    #[On('refresh-category-list')]
    public function setSearch($search)
    {
        $this->search = $search;
    }

    public function render()
    {
        $this->categories = $this->controller->searchCategory($this->search);
        return view('livewire.admin.manage.book.category-modal-body');
    }
}
