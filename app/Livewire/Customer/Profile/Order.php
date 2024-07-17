<?php

namespace App\Livewire\Customer\Profile;

use Livewire\Component;
use Livewire\Attributes\On;
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

    public function getDiscountInfo()
    {
        [$this->points, $this->loyalty, $this->referredNumber, $this->refDiscount] = (new ProfileController)->getDiscountInfo();
    }

    public function getOrders()
    {
        $this->orders = (new ProfileController)->getOrders($this->searchCode, $this->searchDate);
    }

    public function getOrderDetail()
    {
        $this->orderDetail = (new ProfileController)->getOrderDetail($this->order_id);
    }

    public function render()
    {
        $this->getDiscountInfo();
        $this->getOrders();
        return view('livewire.customer.profile.order');
    }
}
