<?php

namespace App\Http\Controllers\Customer\Cart;

use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Models\Discount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class CartController extends Controller
{
    public function getCartDetail()
    {
        $order = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])->where([
            ['customer_id', '=', Auth::id()],
            ['status', '=', false]
        ])->first();

        if (!$order) return null;

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

        $physicalBooks = Book::whereIn('id', $physicalTemp)->orderBy('name', 'asc')->orderBy('edition', 'asc')->get();
        foreach ($physicalBooks as &$book) {
            refineBookData($book);
        }

        $fileBooks = Book::whereIn('id', $fileTemp)->orderBy('name', 'asc')->orderBy('edition', 'asc')->get();
        foreach ($fileBooks as &$book) {
            refineBookData($book);
        }

        $order->hardCovers = $physicalBooks;
        $order->eBooks = $fileBooks;

        return $order;
    }

    public function getPersonalDiscount()
    {
        $customerDiscount = Discount::whereHas('customerDiscount', function (Builder $query) {
            $query->where('point', '<=', Auth::user()->points);
        })->orderBy('discount', 'desc')->first();

        if ($customerDiscount)
            $customerDiscount = $customerDiscount->discount;


        $referrerDiscount = Discount::whereHas('referrerDiscount', function (Builder $query) {
            $query->where('number_of_people', '<=', User::where('referrer_id', Auth::id())->count());
        })->orderBy('discount', 'desc')->first();

        if ($referrerDiscount)
            $referrerDiscount = $referrerDiscount->discount;

        return [$customerDiscount, $referrerDiscount];
    }

    public function updateCart()
    {
        $order = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])->where([
            ['customer_id', '=', Auth::id()],
            ['status', '=', false]
        ])->first();

        if ($order)
            recalculateOrderValue($order->id);
    }

    public function show()
    {
        return view('customer.cart.index');
    }
}
