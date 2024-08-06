<?php

namespace App\Livewire\Admin\Manage\Customer;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\Admin\Manage\Customer;

class CustomerInfoForm extends Component
{
    public $selectedCustomer;
    private $controller;

    public function __construct()
    {
        $this->controller = new Customer();
        $this->selectedCustomer = null;
    }

    #[On('set-customer-id')]
    public function setFields($selectedCustomer)
    {
        $this->selectedCustomer = $selectedCustomer;
    }

    public function render()
    {
        $customer = $this->controller->getCustomer($this->selectedCustomer);
        return view('livewire.admin.manage.customer.customer-info-form');
    }
}
