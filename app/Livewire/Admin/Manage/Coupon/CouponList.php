<?php

namespace App\Livewire\Admin\Manage\Coupon;

use App\Http\Controllers\Admin\Manage\Coupon;
use Livewire\Component;

class CouponList extends Component
{
    public $couponType;
    public $limit;
    public $offset;
    public $search;
    public $status;
    public $total;
    public $coupons;
    private $controller;

    public function __construct()
    {
        $this->couponType = 1;
        $this->limit = 10;
        $this->offset = 0;
        $this->status = true;
        $this->search = null;
        $this->controller = new Coupon();
    }

    public function previous()
    {
        if (!($this->offset <= 0))
            $this->offset--;
    }

    public function next()
    {
        if (!(($this->offset + 1) * $this->limit >= $this->total))
            $this->offset++;
    }

    public function resetPagination()
    {
        $this->offset = 0;
    }

    public function render()
    {
        $this->coupons = $this->controller->getCoupons($this->couponType, $this->search, $this->limit, $this->offset) ?? [];
        $this->total = $this->controller->getTotalCoupons($this->couponType, $this->search) ?? 0;
        return view('livewire.admin.manage.coupon.coupon-list');
    }
}
