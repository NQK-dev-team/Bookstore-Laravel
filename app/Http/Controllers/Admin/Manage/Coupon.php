<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Models\Book;
use App\Models\Discount;
use App\Models\EventDiscount;
use App\Models\CustomerDiscount;
use App\Models\ReferrerDiscount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\NotifyDiscountEvent;
use Illuminate\Database\Eloquent\Builder;
use Haruncpi\LaravelIdGenerator\IdGenerator;

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
                $subConditions[] = [DB::raw('DATE(start_time)'), '>=', $startDate];
            }
            if ($endDate) {
                $subConditions[] = [DB::raw('DATE(end_time)'), '<=', $endDate];
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
        $result = 0;
        DB::transaction(function () use ($couponID, &$result) {
            $coupon = Discount::find($couponID);
            if (Discount::where([['name', '=', $coupon->name], ['status', '=', true],])->whereNot('id', $couponID)->exists()) {
                $result = 1;
                return;
            }

            if ($discount = Discount::whereHas('customerDiscount')->where('id', $couponID)->first()) {
                if (Discount::where('status', true)->whereNot('id', $couponID)->whereHas('customerDiscount', function (Builder $query) use ($discount) {
                    $query->where('point', $discount->customerDiscount->point);
                })->whereNull('deleted_at')->exists() || Discount::whereHas('customerDiscount')->where('status', true)->where('discount', $discount->discount)->whereNot('id', $couponID)->whereNull('deleted_at')->exists()) {
                    $result = 1;
                    return;
                }
            } else if ($discount = Discount::whereHas('referrerDiscount')->where('id', $couponID)->first()) {
                if (Discount::where('status', true)->whereNot('id', $couponID)->whereHas('referrerDiscount', function (Builder $query) use ($discount) {
                    $query->where('number_of_people', $discount->referrerDiscount->number_of_people);
                })->whereNull('deleted_at')->exists() || Discount::whereHas('referrerDiscount')->where('status', true)->where('discount', $discount->discount)->whereNot('id', $couponID)->whereNull('deleted_at')->exists()) {
                    $result = 1;
                    return;
                }
            }

            $coupon->status = true;
            $coupon->save();
        });

        return $result;
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
            $coupon->status = false;
            $coupon->save();
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

            $discount->name = trim($name);
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
                $discount->eventDiscount = new EventDiscount();
                $discount->eventDiscount->id = $id;
                $discount->eventDiscount->start_time = $params[0];
                $discount->eventDiscount->end_time = $params[1];
                if ($params[2]) {
                    $discount->eventDiscount->apply_for_all_books = true;
                } else {
                    $discount->eventDiscount->apply_for_all_books = false;
                    foreach ($params[3] as $book) {
                        $discount->eventDiscount->booksApplied()->attach(Book::find($book));
                    }
                }
                $discount->eventDiscount->save();
                if ($params[4]) {
                    $path = $params[4]->store(path: 'files/email_templates');
                    if (now(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))->diffInDays($params[0]) <= 1) {
                        NotifyDiscountEvent::dispatch($path);
                    } else {
                        NotifyDiscountEvent::dispatch($path)->delay(now(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))->addDay()->diffInSeconds($params[0]));
                    }
                }
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

            $discount->name = trim($name);
            $discount->discount = $discountPercentage;
            if ((int) $couponType === 1) {
                $discount->eventDiscount->start_time = $params[0];
                $discount->eventDiscount->end_time = $params[1];
                if ($params[2]) {
                    $discount->eventDiscount->apply_for_all_books = true;
                    $discount->eventDiscount->booksApplied()->detach();
                } else {
                    $discount->eventDiscount->apply_for_all_books = false;
                    $discount->eventDiscount->booksApplied()->detach();
                    foreach ($params[3] as $book) {
                        $discount->eventDiscount->booksApplied()->attach(Book::find($book));
                    }
                }
                $discount->eventDiscount->save();
                if ($params[4]) {
                    $path = $params[4]->store(path: 'files/email_templates');
                    if (now(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))->diffInDays($params[0]) <= 1) {
                        NotifyDiscountEvent::dispatch($path);
                    } else {
                        NotifyDiscountEvent::dispatch($path)->delay(now(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))->addDay()->diffInSeconds($params[0]));
                    }
                }
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

    public function getBooksApplied($couponID)
    {
        return Discount::whereHas('eventDiscount')->where('id', $couponID)->first()->eventDiscount->booksApplied;
    }

    public function show()
    {
        return view('admin.manage.coupon.index');
    }
}
