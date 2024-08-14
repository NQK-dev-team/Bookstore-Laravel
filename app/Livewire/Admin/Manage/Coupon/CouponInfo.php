<?php

namespace App\Livewire\Admin\Manage\Coupon;

use Closure;
use Livewire\Component;
use App\Models\Discount;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Reactive;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Admin\Manage\Book;
use App\Http\Controllers\Admin\Manage\Coupon;

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
    public $books;
    public $booksDisplayed;
    public $all;
    private $couponController;
    private $bookController;

    public function __construct()
    {
        $this->couponController = new Coupon();
        $this->bookController = new Book();
        $this->couponID = null;
        $this->couponName = null;
        $this->couponDiscount = null;
        $this->numberOfPeople = null;
        $this->point = null;
        $this->startTime = null;
        $this->endTime = null;
        $this->all = false;
        $this->books = [];
        $this->booksDisplayed = "";
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
            $this->books = [];
            $this->booksDisplayed = "";
        } else {
            $discount = $this->couponController->getDiscount($couponID);

            $this->couponName = $discount->name;
            $this->couponDiscount = $discount->discount;
            if ((int)$this->couponType === 1) {
                $this->startTime = $discount->eventDiscount->start_time;
                $this->endTime = $discount->eventDiscount->end_time;
                $this->all = $discount->eventDiscount->apply_for_all_books;
                if (!$this->all) {
                    $result = $this->couponController->getBooksApplied($this->couponID);
                    $this->books = $result->pluck('id')->toArray();
                    $this->displayBooks();
                }
            } else if ((int)$this->couponType === 2) {
                $this->point = $discount->customerDiscount->point;
            } else if ((int)$this->couponType === 3) {
                $this->numberOfPeople = $discount->referrerDiscount->number_of_people;
            }
        }
    }

    public function displayBooks()
    {
        $this->booksDisplayed = "";
        $result = $this->bookController->getBooksByIds($this->books);
        $result = $result->sortBy([['name', 'asc'], ['edition', 'asc']]);
        foreach ($result as $index => $book) {
            $book->edition = convertToOrdinal($book->edition);
            $this->booksDisplayed .= "{$book->name} - {$book->edition}";
            if ($index < count($result) - 1) {
                $this->booksDisplayed .= "\n";
            }
        }
    }

    #[On('remove-book-applied')]
    public function removeBook($bookID)
    {
        $index = array_search($bookID, $this->books);
        if ($index !== false) {
            unset($this->books[$index]);
            $this->displayBooks();
        }
    }

    #[On('add-book-applied')]
    public function addBook($bookID)
    {
        if (!in_array($bookID, $this->books)) {
            $this->books[] = $bookID;
            $this->displayBooks();
        }
    }

    public function updateCoupon()
    {
        $this->couponName = $this->couponName ? trim($this->couponName) : '';

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
            $this->couponController->updateDiscount($this->couponType, $this->couponID, $this->couponName, $this->couponDiscount, $this->point);
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
            $this->couponController->updateDiscount($this->couponType, $this->couponID, $this->couponName, $this->couponDiscount, $this->numberOfPeople);
        }
        $this->dispatch('dismiss-coupon-info-modal');
    }

    public function createCoupon()
    {
        $this->couponName = $this->couponName ? trim($this->couponName) : '';

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
            $this->couponController->createDiscount($this->couponType, $this->couponName, $this->couponDiscount, $this->point);
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
            $this->couponController->createDiscount($this->couponType, $this->couponName, $this->couponDiscount, $this->numberOfPeople);
        }
        $this->dispatch('dismiss-coupon-info-modal');
    }

    public function render()
    {
        return view('livewire.admin.manage.coupon.coupon-info');
    }
}
