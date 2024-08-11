<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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

    public function show()
    {
        return view('admin.manage.coupon.index');
    }
}
