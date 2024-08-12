<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Models\CustomerDiscount;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ReferrerDiscount;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Builder;

class Coupon extends Controller
{
    public function getTotalCoupons($couponType = 1, $search, $status, $startDate, $endDate)
    {
        if (!$search)
            $search = '';
        else
            $search = trim($search);

        if ((int)$couponType === 1) {
            $subConditions = [];
            if ($startDate) {
                $subConditions[] = ['start_time', '>=', $startDate];
            }
            if ($endDate) {
                $subConditions[] = ['end_time', '<=', $endDate];
            }
            return Discount::whereHas('eventDiscount', function (Builder $query) use ($subConditions) {
                $query->where($subConditions);
            })
                ->where([
                    ['status', '=', $status],
                    ['name', 'ilike', '%' . $search . '%'],
                ])
                ->count();
        } else if ((int)$couponType === 2) {
            return Discount::whereHas('customerDiscount')
                ->where([
                    ['status', '=', $status],
                    ['name', 'ilike', '%' . $search . '%'],
                ])
                ->count();
        } else if ((int)$couponType === 3) {
            return Discount::whereHas('referrerDiscount')
                ->where([
                    ['status', '=', $status],
                    ['name', 'ilike', '%' . $search . '%'],
                ])
                ->count();
        }
    }

    public function getCoupons($couponType = 1, $search, $status,  $limit, $offset, $startDate, $endDate)
    {
        if (!$search)
            $search = '';
        else
            $search = trim($search);

        if ((int)$couponType === 1) {
            $subConditions = [];
            if ($startDate) {
                $subConditions[] = ['start_time', '>=', $startDate];
            }
            if ($endDate) {
                $subConditions[] = ['end_time', '<=', $endDate];
            }
            return Discount::select('*')
                ->join('event_discounts', 'discounts.id', '=', 'event_discounts.id')
                ->where($subConditions)
                ->where([
                    ['status', '=', $status],
                    ['name', 'ilike', '%' . $search . '%'],
                ])
                ->limit($limit)->offset($offset)->orderBy('start_time', 'desc')->orderBy('end_time', 'desc')->orderBy('discount', 'asc')->get();
        } else if ((int)$couponType === 2) {
            return Discount::whereHas('customerDiscount') //->with('customerDiscount') // for some reason when eager loading it returns null???
                ->where([
                    ['status', '=', $status],
                    ['name', 'ilike', '%' . $search . '%'],
                ])->limit($limit)->offset($offset)->orderBy('discount', 'asc')->orderBy('name', 'asc')->get();
        } else if ((int)$couponType === 3) {
            return Discount::whereHas('referrerDiscount')->with('referrerDiscount')
                ->where([
                    ['status', '=', $status],
                    ['name', 'ilike', '%' . $search . '%'],
                ])->limit($limit)->offset($offset)->orderBy('discount', 'asc')->orderBy('name', 'asc')->get();
        }
    }

    public function activateDiscount($couponID)
    {
        DB::transaction(function () use ($couponID) {
            $coupon = Discount::find($couponID);
            $coupon->status = true;
            $coupon->save();
        });
    }

    public function deactivateDiscount($couponID)
    {
        DB::transaction(function () use ($couponID) {
            $coupon = Discount::find($couponID);
            $coupon->status = false;
            $coupon->save();
        });
    }

    public function deleteDiscount($couponID)
    {
        DB::transaction(function () use ($couponID) {
            $coupon = Discount::find($couponID);
            $coupon->delete();
        });
    }

    public function getDiscount($couponID)
    {
        return Discount::find($couponID);
    }

    public function createDiscount($couponType = 1, $name, $discountPercentage, ...$params)
    {
        DB::transaction(function () use ($couponType, $name, $discountPercentage, $params) {
            $discount = new Discount();
            $id = null;

            $discount->name = $name;
            $discount->discount = $discountPercentage;
            if ((int) $couponType === 1) {
                $discount->id = IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' => 'D-E-', 'reset_on_prefix_change' => true]);
                $id = $discount->id;
                $discount->save();
            } elseif ((int) $couponType === 2) {
                $discount->id = IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' => 'D-C-', 'reset_on_prefix_change' => true]);
                $id = $discount->id;
                $discount->save();
            } elseif ((int) $couponType === 3) {
                $discount->id = IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' => 'D-R-', 'reset_on_prefix_change' => true]);
                $id = $discount->id;
                $discount->save();
            }

            if ((int) $couponType === 1) {
                $discount = Discount::find($id);
            } elseif ((int) $couponType === 2) {
                $discount = Discount::find($id);
                $discount->customerDiscount = new CustomerDiscount();
                $discount->customerDiscount->id = $discount->id;
                $discount->customerDiscount->point = $params[0];
                $discount->customerDiscount->save();
            } elseif ((int) $couponType === 3) {
                $discount = Discount::find($id);
                $discount->referrerDiscount = new ReferrerDiscount();
                $discount->referrerDiscount->id = $discount->id;
                $discount->referrerDiscount->number_of_people = $params[0];
                $discount->referrerDiscount->save();
            }
        });
    }

    public function updateDiscount($couponType = 1, $id, $name, $discountPercentage, ...$params)
    {
        DB::transaction(function () use ($couponType, $id, $name, $discountPercentage, $params) {
            $discount = Discount::find($id);

            $discount->name = $name;
            $discount->discount = $discountPercentage;
            if ((int) $couponType === 1) {
            } elseif ((int) $couponType === 2) {
                $discount->customerDiscount->point = $params[0];
                $discount->customerDiscount->save();
            } elseif ((int) $couponType === 3) {
                $discount->referrerDiscount->number_of_people = $params[0];
                $discount->referrerDiscount->save();
            }
            $discount->save();
        });
    }

    public function show()
    {
        return view('admin.manage.coupon.index');
    }
}
