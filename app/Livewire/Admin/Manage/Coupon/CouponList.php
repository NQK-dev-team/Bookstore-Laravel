<?php

namespace App\Livewire\Admin\Manage\Coupon;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\Admin\Manage\Coupon;
use Livewire\Attributes\Renderless;

class CouponList extends Component
{
    public $couponType;
    public $limit;
    public $offset;
    public $search;
    public $status;
    public $total;
    public $coupons;
    public $startDate;
    public $endDate;
    public $couponID;
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

    public function deleteCoupon()
    {
        $this->controller->deleteDiscount($this->couponID);
    }

    public function deactivateCoupon()
    {
        $this->controller->deactivateDiscount($this->couponID);
    }

    public function reactivateCoupon()
    {
        if ($this->controller->activateDiscount($this->couponID)) {
            $this->dispatch('activate-error-modal');
        }
    }

    #[On('reset-coupon-id')]
    public function resetCouponSelection()
    {
        $this->couponID = null;
        $this->dispatch('set-coupon-id', couponID: $this->couponID);
    }

    #[Renderless]
    public function setCouponID($couponID)
    {
        $this->couponID = $couponID;
        $this->dispatch('set-coupon-id', couponID: $this->couponID);
    }

    public function render()
    {
        $this->coupons = $this->controller->getCoupons($this->couponType, $this->search, $this->status,  $this->limit, $this->offset, $this->startDate, $this->endDate) ?? [];
        $this->total = $this->controller->getTotalCoupons($this->couponType, $this->search, $this->status,  $this->startDate, $this->endDate) ?? 0;
        return view('livewire.admin.manage.coupon.coupon-list');
    }
}
