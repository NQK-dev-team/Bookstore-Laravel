<?php

namespace App\Livewire\Admin\Manage\Customer;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\Admin\Manage\Customer;

class CustomerOrderDetail extends Component
{
    public $orderID;
    public $orderDetail;
    private $controller;

    public function __construct()
    {
        $this->controller = new Customer();
        $this->orderDetail = null;
        $this->orderID = null;
    }

    #[On('get-customer-order-detail')]
    public function getOrderDetail($orderID)
    {
        $this->orderID = $orderID;
    }

    public function render()
    {
        $this->orderDetail = $this->orderID ? $this->controller->getOrderDetail($this->orderID) : null;
        return view('livewire.admin.manage.customer.customer-order-detail');
    }
}
