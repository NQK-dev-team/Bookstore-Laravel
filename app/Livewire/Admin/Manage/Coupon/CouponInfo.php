<?php

namespace App\Livewire\Admin\Manage\Coupon;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;

class CouponInfo extends Component
{
    public $couponID;
    #[Reactive]
    public $couponType;
    public $couponName;
    public $couponDiscount;
    public $numberOfPeople;
    public $point;
    public $startTime;
    public $endTime;

    #[On('set-coupon-id')]
    public function setCouponID($couponID)
    {
        $this->couponID = $couponID;
    }

    public function updateCoupon() {}

    public function createCoupon() {}

    public function render()
    {
        return view('livewire.admin.manage.coupon.coupon-info');
    }
}
