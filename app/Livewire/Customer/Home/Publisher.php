<?php

namespace App\Livewire\Customer\Home;

use Livewire\Component;
use App\Http\Controllers\Customer\Home;

class Publisher extends Component
{
    public $topPublishers;

    public function render()
    {
        $this->topPublishers = Home::getTopPublishers();
        return view('livewire.customer.home.publisher');
    }
}
