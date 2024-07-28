<?php

namespace App\Http\Controllers\Customer\Profile;

use Closure;
use Carbon\Carbon;
use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Models\Discount;
use voku\helper\AntiXSS;
use App\Mail\PasswordChange;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => ['required', 'numeric', 'digits:10', Rule::unique('users', 'phone')->whereNot('id', Auth::user()->id)->whereNull('deleted_at')],
            'dob' => ['required', 'date', 'before_or_equal:' . Carbon::now()->timezone(env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh'))->subYears(18)->toDateString()],
            'gender' => 'required|in:M,F,O',
            'address' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'dob.before_or_equal' => 'You must be at least 18 years old.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('customer.profile.index', ['option' => 1])->withErrors($validator)->withInput();
        }

        $antiXss = new AntiXSS();

        DB::transaction(function () use ($request, $antiXss) {
            $data = User::find(Auth::user()->id);
            $data->name = $antiXss->xss_clean($request->name);
            $data->phone = $antiXss->xss_clean($request->phone);
            $data->gender = $antiXss->xss_clean($request->gender);
            $data->address = $antiXss->xss_clean($request->address);
            $data->dob = $antiXss->xss_clean($request->dob);

            if ($request->hasFile('image')) {
                $imagePath = Storage::putFileAs('files/images/users/customers/' . Auth::user()->id, $request->file('image'), date('YmdHis', time()) . '.' . $request->file('image')->extension());
                $data->image = $imagePath;
            }

            $data->save();
        });

        return redirect()->route('customer.profile.index', ['option' => 1]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currentPassword' => ['required', function (string $attribute, mixed $value, Closure $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'newPassword' => ['required', 'string', 'different:currentPassword', Password::min(8)->mixedCase()->numbers()->symbols()],
            'confirmPassword' => 'required|same:newPassword',
        ], [
            'dob.before_or_equal' => 'You must be at least 18 years old to register.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('customer.profile.index', ['option' => 3])->withErrors($validator)->withInput();
        }

        $antiXss = new AntiXSS();

        DB::transaction(function () use ($request, $antiXss) {
            User::where([['id', '=', Auth::user()->id]])->update([
                'password' => Hash::make($antiXss->xss_clean($request->newPassword)),
            ]);
        });
        Mail::to(Auth::user()->email)->queue(new PasswordChange(Auth::user()->name));
        session()->flash('password-changed', 1);

        return redirect()->route('customer.profile.index', ['option' => 3]);
    }

    public function getDiscountInfo()
    {
        $points = Auth::user()->points;

        $customerDiscount = Discount::whereHas('customerDiscount', function (Builder $query) {
            $query->where('point', '<=', Auth::user()->points);
        })->orderBy('discount', 'desc')->first();

        if ($customerDiscount)
            $customerDiscount = $customerDiscount->discount;

        $referredNumber = User::where('referrer_id', Auth::id())->count();

        $referrerDiscount = Discount::whereHas('referrerDiscount', function (Builder $query) {
            $query->where('number_of_people', '<=', User::where('referrer_id', Auth::id())->count());
        })->orderBy('discount', 'desc')->first();

        if ($referrerDiscount)
            $referrerDiscount = $referrerDiscount->discount;

        return [$points, $customerDiscount, $referredNumber, $referrerDiscount];
    }

    public function getOrders($searchCode, $searchDate)
    {
        $conditions = [
            ['customer_id', '=', Auth::id()],
            ['status', '=', true],
        ];

        if ($searchCode) {
            $searchCode = str_replace('-', '', $searchCode);
            $conditions[] = ['code', 'ilike', '%' . $searchCode . '%'];
        }

        if ($searchDate)
            $orders = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])->where($conditions)->whereDate('updated_at', '=', $searchDate)->orderBy('updated_at', 'desc')->orderBy('total_price', 'desc')->orderBy('total_discount', 'desc')->get();
        else
            $orders = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])->where($conditions)->orderBy('updated_at', 'desc')->orderBy('total_price', 'desc')->orderBy('total_discount', 'desc')->get();

        foreach ($orders as $order) {
            $order->books = [];
            $temp = [];

            if ($order->physicalOrder) {
                $books = $order->physicalOrder->physicalCopies;

                foreach ($books as $book) {
                    if (!in_array($book->id, $temp)) {
                        $temp[] = $book->id;
                    }
                }
            }

            if ($order->fileOrder) {
                $books = $order->fileOrder->fileCopies;

                foreach ($books as $book) {
                    if (!in_array($book->id, $temp)) {
                        $temp[] = $book->id;
                    }
                }
            }

            $books = [];
            foreach ($temp as $elem) {
                $refinedData = refineBookData(Book::withTrashed()->find($elem));
                $books[] = ['name' => $refinedData->name, 'edition' => $refinedData->edition];
            }
            usort($books, function ($a, $b) {
                return strcmp($a['name'], $b['name']) ?: strcmp($a['edition'], $b['edition']);
            });

            $order->books = $books;
        }

        return $orders;
    }

    public function getOrderDetail($id)
    {
        $order = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])->find($id);

        if (!$order)
            return null;

        $physicalTemp = [];
        if ($order->physicalOrder) {
            $books = $order->physicalOrder->physicalCopies;

            foreach ($books as $book) {
                if (!in_array($book->id, $physicalTemp)) {
                    $physicalTemp[] = $book->id;
                }
            }
        }

        $fileTemp = [];
        if ($order->fileOrder) {
            $books = $order->fileOrder->fileCopies;

            foreach ($books as $book) {
                if (!in_array($book->id, $fileTemp)) {
                    $fileTemp[] = $book->id;
                }
            }
        }

        // $physicalBooks = [];
        // foreach ($physicalTemp as $elem) {
        //     $physicalBooks[] = refineBookData(Book::find($elem));
        // }

        // // Order by name and edition
        // $physicalBooks = collect($physicalBooks)->sortBy('name')->sortBy('edition')->values()->all();
        $physicalBooks = Book::whereIn('id', $physicalTemp)->withTrashed()->orderBy('name', 'asc')->orderBy('edition', 'asc')->get();
        foreach ($physicalBooks as &$book) {
            refineBookData($book);
        }

        // $fileBooks = [];
        // foreach ($fileTemp as $elem) {
        //     $fileBooks[] = refineBookData(Book::find($elem), false);
        // }

        // // Order by name and edition
        // $fileBooks = collect($fileBooks)->sortBy('name')->sortBy('edition')->values()->all();
        $fileBooks = Book::whereIn('id', $fileTemp)->withTrashed()->orderBy('name', 'asc')->orderBy('edition', 'asc')->get();
        foreach ($fileBooks as &$book) {
            refineBookData($book, false);
        }

        $order->hardCovers = $physicalBooks;
        $order->eBooks = $fileBooks;

        return $order;
    }

    public function show(Request $request)
    {
        $option = $request->query('option', 1);
        return view('customer.profile.index', ['option' => $option]);
    }
}
