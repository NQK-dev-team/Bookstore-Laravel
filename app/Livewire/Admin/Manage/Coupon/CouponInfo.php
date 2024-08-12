<?php

namespace App\Livewire\Admin\Manage\Coupon;

use Closure;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Reactive;
use App\Http\Controllers\Admin\Manage\Coupon;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Builder;

class CouponInfo extends Component
{
    public $couponID;
    #[Reactive]
    public $couponType;
    #[Reactive]
    public $status;
    public $couponName;
    public $couponDiscount;
    public $numberOfPeople;
    public $point;
    public $startTime;
    public $endTime;
    // public $books;
    public $all;
    private $controller;

    public function __construct()
    {
        $this->controller = new Coupon();
        $this->couponID = null;
    }

    #[On('set-coupon-id')]
    public function setCouponID($couponID)
    {
        $this->couponID = $couponID;
        if (!$couponID) {
            $this->resetErrorBag();
            $this->couponName = null;
            $this->couponDiscount = null;
            $this->numberOfPeople = null;
            $this->point = null;
            $this->startTime = null;
            $this->endTime = null;
            $this->all = false;
        } else {
            $discount = $this->controller->getDiscount($couponID);

            $this->couponName = $discount->name;
            $this->couponDiscount = $discount->discount;
            if ((int)$this->couponType === 1) {
                $this->startTime = $discount->eventDiscount->start_time;
                $this->endTime = $discount->eventDiscount->end_time;
                $this->all = $discount->eventDiscount->apply_for_all_books;
            } else if ((int)$this->couponType === 2) {
                $this->point = $discount->customerDiscount->point;
            } else if ((int)$this->couponType === 3) {
                $this->numberOfPeople = $discount->referrerDiscount->number_of_people;
            }
        }
    }

    public function updateCoupon()
    {
        if ((int)$this->couponType === 1) {
        } else if ((int)$this->couponType === 2) {
            $nameRules = ['required', 'string', 'max:255'];
            $discountRules = ['required', 'numeric', 'min:0', 'max:100'];
            $pointRules = ['required', 'numeric', 'min:0'];
            if ($this->status) {
                $nameRules[] = Rule::unique('discounts', 'name')->where('status', true)->whereNot('id', $this->couponID)->whereNull('deleted_at');
                $discountRules[] = function (string $attribute, mixed $value, Closure $fail) {
                    if (Discount::whereHas('customerDiscount')->where([['status', '=', true], ['discount', '=', $value], ['id', '!=', $this->couponID],])->whereNull('deleted_at')->exists()) {
                        $fail('The discount percentage milestone has been used!');
                    }
                };
                $pointRules[] = function (string $attribute, mixed $value, Closure $fail) {
                    if (Discount::whereHas('customerDiscount', function (Builder $query) use ($value) {
                        $query->where([['point', '=', $value],]);
                    })->where([['status', '=', true], ['id', '!=', $this->couponID],])->whereNull('deleted_at')->exists()) {
                        $fail('The accumulated point milestone has been used!');
                    }
                };
            }
            $this->validate([
                'couponName' => $nameRules,
                'couponDiscount' => $discountRules,
                'point' => $pointRules,
            ]);
            $this->controller->updateDiscount($this->couponType, $this->couponID, $this->couponName, $this->couponDiscount, $this->point);
        } else if ((int)$this->couponType === 3) {
            $nameRules = ['required', 'string', 'max:255'];
            $discountRules = ['required', 'numeric', 'min:0', 'max:100'];
            $peopleRules = ['required', 'numeric', 'min:0'];
            if ($this->status) {
                $nameRules[] = Rule::unique('discounts', 'name')->where('status', true)->whereNot('id', $this->couponID)->whereNull('deleted_at');
                $discountRules[] = function (string $attribute, mixed $value, Closure $fail) {
                    if (Discount::whereHas('referrerDiscount')->where([['status', '=', true], ['discount', '=', $value], ['id', '!=', $this->couponID],])->whereNull('deleted_at')->exists()) {
                        $fail('The discount percentage milestone has been used!');
                    }
                };
                $peopleRules[] = function (string $attribute, mixed $value, Closure $fail) {
                    if (Discount::whereHas('referrerDiscount', function (Builder $query) use ($value) {
                        $query->where([['number_of_people', '=', $value],]);
                    })->where([['status', '=', true], ['id', '!=', $this->couponID],])->whereNull('deleted_at')->exists()) {
                        $fail('The number of people milestone has been used!');
                    }
                };
            }
            $this->validate([
                'couponName' => $nameRules,
                'couponDiscount' => $discountRules,
                'numberOfPeople' => $peopleRules,
            ]);
            $this->controller->updateDiscount($this->couponType, $this->couponID, $this->couponName, $this->couponDiscount, $this->numberOfPeople);
        }
        $this->dispatch('dismiss-coupon-info-modal');
    }

    public function createCoupon()
    {
        if ((int)$this->couponType === 1) {
        } else if ((int)$this->couponType === 2) {
            $this->validate([
                'couponName' => ['required', Rule::unique('discounts', 'name')->where('status', true)->whereNull('deleted_at')],
                'couponDiscount' => [
                    'required',
                    function (string $attribute, mixed $value, Closure $fail) {
                        if (Discount::whereHas('customerDiscount')->where([['status', '=', true], ['discount', '=', $value],])->whereNull('deleted_at')->exists()) {
                            $fail('The discount percentage milestone has been used!');
                        }
                    }
                ],
                'point' => [
                    'required',
                    function (string $attribute, mixed $value, Closure $fail) {
                        if (
                            Discount::whereHas('customerDiscount', function (Builder $query) use ($value) {
                                $query->where([['point', '=', $value],]);
                            })->where([['status', '=', true],])->whereNull('deleted_at')->exists()
                        ) {
                            $fail('The accumulated point milestone has been used!');
                        }
                    }
                ],
            ]);
            $this->controller->createDiscount($this->couponType, $this->couponName, $this->couponDiscount, $this->point);
        } else if ((int)$this->couponType === 3) {
            $this->validate([
                'couponName' => ['required', Rule::unique('discounts', 'name')->where('status', true)->whereNull('deleted_at')],
                'couponDiscount' => ['required', function (string $attribute, mixed $value, Closure $fail) {
                    if (Discount::whereHas('referrerDiscount')->where([['status', '=', true], ['discount', '=', $value],])->whereNull('deleted_at')->exists()) {
                        $fail('The discount percentage milestone has been used!');
                    }
                }],
                'numberOfPeople' => ['required', function (string $attribute, mixed $value, Closure $fail) {
                    if (Discount::whereHas('referrerDiscount', function (Builder $query) use ($value) {
                        $query->where([['number_of_people', '=', $value],]);
                    })->where([['status', '=', true],])->whereNull('deleted_at')->exists()) {
                        $fail('The number of people milestone has been used!');
                    }
                }],
            ]);
            $this->controller->createDiscount($this->couponType, $this->couponName, $this->couponDiscount, $this->numberOfPeople);
        }
        $this->dispatch('dismiss-coupon-info-modal');
    }

    public function render()
    {
        return view('livewire.admin.manage.coupon.coupon-info');
    }
}
