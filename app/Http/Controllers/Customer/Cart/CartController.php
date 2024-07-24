<?php

namespace App\Http\Controllers\Customer\Cart;

use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Models\Discount;
use App\Models\FileOrder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PhysicalOrder;
use App\Models\FileOrderContain;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PhysicalOrderContain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Database\Eloquent\Builder;

class CartController extends Controller
{
    private $paypalClientId;
    private $paypalClientSecret;
    private $paypalCurrency;

    public function __construct()
    {
        $this->paypalClientId = env('PAYPAL_SANDBOX_CLIENT_ID', '');
        $this->paypalClientSecret = env('PAYPAL_SANDBOX_CLIENT_SECRET', '');
        $this->paypalCurrency = env('PAYPAL_CURRENCY', '');
    }

    public function getCartDetail($customerID = null)
    {
        $order = Order::with(['physicalOrder' => ['physicalCopies'], 'fileOrder' => ['fileCopies']])->where([
            ['customer_id', '=', $customerID ?? Auth::id()],
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

    public function purchase()
    {
        DB::transaction(function () {
        });
    }

    public function getPaypalAccessToken()
    {
        $basic = "{$this->paypalClientId}:{$this->paypalClientSecret}";
        $basic = Str::toBase64($basic);

        $response = Http::asForm()->withHeaders([
            'Authorization' => "Basic {$basic}",
            'Content-Type' => 'application/json',
        ])->withOptions([
            'verify' => false,
        ])->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', ["grant_type" => "client_credentials"]);

        $responseBody = $response->json();

        return $responseBody["access_token"];
    }

    public function createPaypalOrder(Request $request)
    {
        $paypalToken = $request->cookie('paypal_token');

        [$id, $_] = explode('|', $paypalToken);

        $token = PersonalAccessToken::find($id);

        if (!$token) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
        if ($token->expires_at->isPast()) {
            return response()->json(['message' => 'Token expired.'], 419);
        }

        $customerID = $token->tokenable_id;

        $cart = $this->getCartDetail($customerID);

        // return actions.order.create({
        //     "purchase_units": [{
        //         "reference_id": crypto.randomUUID(),
        //         "amount": {
        //             "currency_code": currency,
        //             "value": totalPrice,
        //             "breakdown": {
        //                 "item_total": {
        //                     "currency_code": currency,
        //                     "value": itemTotal,
        //                 },
        //                 "tax_total": {
        //                     "currency_code": currency,
        //                     "value": tax,
        //                 },
        //                 "shipping": {
        //                     "currency_code": currency,
        //                     "value": shipping,
        //                 },
        //                 "handling": {
        //                     "currency_code": currency,
        //                     "value": handling,
        //                 },
        //                 "insurance": {
        //                     "currency_code": currency,
        //                     "value": insurance,
        //                 },
        //                 "shipping_discount": {
        //                     "currency_code": currency,
        //                     "value": shippingDiscount,
        //                 },
        //                 "discount": {
        //                     "currency_code": currency,
        //                     "value": discount,
        //                 },
        //             },
        //         },
        //         "items": items,
        //     }],
        //     intent: "CAPTURE",
        // });

        // $payload = [];
        // $payload['intent'] = 'CAPTURE';

        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => '100'
                    ]
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->getPaypalAccessToken()}",
            'Content-Type' => 'application/json',
        ])->withOptions([
            'verify' => false,
        ])->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', $payload);

        return $response;
    }

    public function capturePaypalOrder(Request $request)
    {
        $paypalToken = $request->cookie('paypal_token');

        [$id, $_] = explode('|', $paypalToken);

        $token = PersonalAccessToken::find($id);

        if (!$token) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
        if ($token->expires_at->isPast()) {
            return response()->json(['message' => 'Token expired.'], 419);
        }

        $orderID = $request->id;
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->getPaypalAccessToken()}",
            'Content-Type' => 'application/json',
        ])->withOptions([
            'verify' => false,
        ])->post("https://api-m.sandbox.paypal.com/v2/checkout/orders/{$orderID}/capture", ['json' => []]);

        return $response;
    }

    public function show()
    {
        return view('customer.cart.index');
    }
}