<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Coupon extends Controller
{
    public function getTotalCoupons($couponType = 1, $search) {}

    public function getCoupons($couponType = 1, $search, $limit, $offset) {}

    public function show()
    {
        return view('admin.manage.coupon.index');
    }
}
