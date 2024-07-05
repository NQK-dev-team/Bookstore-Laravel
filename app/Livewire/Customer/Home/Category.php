<?php

namespace App\Livewire\Customer\Home;

use App\Http\Controllers\Customer\Home;
use Livewire\Component;

class Category extends Component
{
    public $topCategories;


    public function render()
    {
        $this->topCategories = Home::getTopCategories();
        return view('livewire.customer.home.category');
    }
}
