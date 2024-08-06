<?php

namespace App\Livewire\Admin\Manage\Customer;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use App\Http\Controllers\Admin\Manage\Customer;
use Livewire\Attributes\Renderless;

class CustomerOrder extends Component
{
    #[Reactive]
    public $customerID;
    public $searchCode;
    public $searchDate;
    public $orders;
    public $points;
    public $loyalty;
    public $referredNumber;
    public $refDiscount;
    private $controller;

    public function __construct()
    {
        $this->controller = new Customer();
    }

    #[Renderless]
    public function getOrderDetail($orderID)
    {
        $this->dispatch('get-customer-order-detail', orderID: $orderID)->to(CustomerOrderDetail::class);
    }

    #[Renderless]
    public function clearOrderDetail()
    {
        $this->dispatch('get-customer-order-detail', orderID: null)->to(CustomerOrderDetail::class);
    }

    public function render()
    {
        $customer = $this->controller->getCustomer($this->customerID);
        if ($customer) {
            [$this->points, $this->loyalty, $this->referredNumber, $this->refDiscount] = $this->controller->getDiscountInfo($this->customerID);
            $this->orders = $this->controller->getOrders($this->customerID, $this->searchCode, $this->searchDate);
        } else {
            $this->points = 0;
            $this->loyalty = 0;
            $this->referredNumber = 0;
            $this->refDiscount = 0;
            $this->searchCode = '';
            $this->orders = [];
        }
        return view('livewire.admin.manage.customer.customer-order');
    }
}
