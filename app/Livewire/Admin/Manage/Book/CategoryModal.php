<?php

namespace App\Livewire\Admin\Manage\Book;

use Livewire\Attributes\Renderless;
use Livewire\Component;

class CategoryModal extends Component
{
    public $searchCategory;
    public $preSelectedCategories;

    #[Renderless]
    public function refreshCategoryList()
    {
        $this->dispatch('refresh-category-list', search: $this->searchCategory);
    }

    public function render()
    {
        return view('livewire.admin.manage.book.category-modal');
    }
}
