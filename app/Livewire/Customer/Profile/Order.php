<?php

namespace App\Livewire\Customer\Profile;

use Livewire\Component;

class Order extends Component
{
    public $order_id;

    public function render()
    {
        return view('livewire.customer.profile.order');
    }
}
