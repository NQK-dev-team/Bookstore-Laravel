<?php

namespace App\Livewire\Customer\Profile;

use Livewire\Component;
use App\Http\Controllers\Customer\Profile\ProfileController;

class Order extends Component
{
    public $order_id;
    public $points;
    public $loyalty;
    public $referredNumber;
    public $refDiscount;
    public $orders;
    public $searchCode;
    public $searchDate;
    public $orderDetail;
    private $controller;

    public function __construct()
    {
        $this->controller = new ProfileController;
    }

    public function getDiscountInfo()
    {
        [$this->points, $this->loyalty, $this->referredNumber, $this->refDiscount] = $this->controller->getDiscountInfo();
    }

    public function getOrders()
    {
        $this->orders = $this->controller->getOrders($this->searchCode, $this->searchDate);
    }

    public function getOrderDetail()
    {
        $this->orderDetail = $this->controller->getOrderDetail($this->order_id);
    }

    public function render()
    {
        $this->getDiscountInfo();
        $this->getOrders();
        return view('livewire.customer.profile.order');
    }
}
