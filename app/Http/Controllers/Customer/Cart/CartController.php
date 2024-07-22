<?php

namespace App\Http\Controllers\Customer\Cart;

use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Models\Discount;
use App\Models\FileOrder;
use App\Models\PhysicalOrder;
use App\Models\FileOrderContain;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PhysicalOrderContain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Omnipay\Omnipay;

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

    public function updateAddress($address)
    {
        DB::transaction(
            function () use ($address) {
                $order = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])->where([
                    ['customer_id', '=', Auth::id()],
                    ['status', '=', false]
                ])->first();

                if (!$order || !$order->physicalOrder)
                    return;

                $order->physicalOrder->address = $address;
                $order->physicalOrder->save();
            }
        );
    }

    public function updateAmount($id, $amount)
    {
        DB::transaction(function () use ($id, $amount) {
            $order = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])->where([
                ['customer_id', '=', Auth::id()],
                ['status', '=', false]
            ])->first();

            if (!$order || !$order->physicalOrder)
                return;

            $order->physicalOrder->physicalCopies()->updateExistingPivot($id, ['amount' => $amount]);
        });
        $this->updateCart();
    }

    public function deleteBook($id, $mode)
    {
        DB::transaction(function () use ($id, $mode) {
            $order = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])->where([
                ['customer_id', '=', Auth::id()],
                ['status', '=', false]
            ])->first();

            if ($mode === 1)
                $order->physicalOrder->physicalCopies()->detach($id);
            else if ($mode === 2)
                $order->fileOrder->fileCopies()->detach($id);
            $order->save();

            if (PhysicalOrder::where('id', $order->id)->exists() && !PhysicalOrderContain::where('order_id', $order->id)->exists())
                PhysicalOrder::where('id', $order->id)->delete();

            if (FileOrder::where('id', $order->id)->exists() && !FileOrderContain::where('order_id', $order->id)->exists())
                FileOrder::where('id', $order->id)->delete();

            if (Order::where('id', $order->id)->exists() && !PhysicalOrder::where('id', $order->id)->exists() && !FileOrder::where('id', $order->id)->exists())
                Order::where('id', $order->id)->delete();
        });
        $this->updateCart();
    }

    public function getCurrentAddress()
    {
        $order = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])->where([
            ['customer_id', '=', Auth::id()],
            ['status', '=', false]
        ])->first();

        if (!$order) return null;

        return $order->physicalOrder->address;
    }

    public function purchase($mode, $paypalData = null)
    {
        if ($mode === 2) {
            $gateWay = Omnipay::create('PayPal_Rest');
            $gateWay->setClientID(env('PAYPAL_SANDBOX_CLIENT_ID', ''));
            $gateWay->setClientSecret(env('PAYPAL_SANDBOX_CLIENT_SECRET', ''));
            $gateWay->setTestMode(true);

            // $response  = Http::withHeaders([
            //     'Authorization' => 'Bearer ' . $paypalData['facilitatorAccessToken'],
            //     'Content-Type' => 'application/json',
            // ])->withOptions([
            //     'verify' => false,
            // ])->get('https://api-m.sandbox.paypal.com/v2/checkout/orders/' . $paypalData['orderID']);

            // if ($response->failed())
            //     abort($response->status());

            // $data = $response->json();

            // abort(400, $data);
        }
        DB::transaction(function () {
        });
    }

    public function show()
    {
        return view('customer.cart.index');
    }
}
