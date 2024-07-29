<?php

namespace App\Http\Controllers\Customer\Cart;

use Exception;
use App\Models\Book;
use App\Models\User;
use PhpParser\Error;
use App\Models\Order;
use App\Models\Discount;
use App\Models\FileOrder;
use App\Mail\PurchaseOrder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PhysicalOrder;
use App\Models\FileOrderContain;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PhysicalOrderContain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
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

        $physicalBooks = Book::with('physicalCopy')->whereIn('id', $physicalTemp)->orderBy('name', 'asc')->orderBy('edition', 'asc')->get();
        foreach ($physicalBooks as &$book) {
            refineBookData($book);
        }

        $fileBooks = Book::with('fileCopy')->whereIn('id', $fileTemp)->orderBy('name', 'asc')->orderBy('edition', 'asc')->get();
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

    public function purchase($customerID = null)
    {
        $result = true;
        $orderID = null;
        try {
            DB::beginTransaction();
            $order = Order::with(['physicalOrder' => ['physicalCopies']])->where([
                ['customer_id', '=', $customerID ?? Auth::id()],
                ['status', '=', false]
            ])->first();
            // $this->getCartDetail($customerID);

            if (!$order)
                throw new Exception('Cart is empty.');

            $order->status = true;
            while ($code = Str::of(Str::random(16))->upper()) {
                if (!Order::where('code', $code)->exists()) {
                    $order->code = $code;
                    break;
                }
            }
            $order->save();

            $totalPrice = $order->total_price;
            $user = User::find($customerID ?? Auth::id());
            $user->points += $totalPrice * env('STORE_POINT_CONVERSION_RATE', '10') / 100;
            $user->save();

            if ($order->physicalOrder) {
                foreach ($order->physicalOrder->physicalCopies as $book) {
                    $stock = $book->quantity;
                    $amount = getAmount($order->id, $book->id);
                    $book->quantity = $stock - $amount;
                    $book->save();
                }
            }

            if (!$customerID) {
                DB::commit();
                Mail::to(Auth::user()->email)->queue(new PurchaseOrder($order->id));
            } else {
                $orderID = $order->id;
            }
        } catch (Exception $e) {
            if (!$customerID) {
                DB::rollback();
            }
            $result = false;
        }

        if (!$customerID)
            return $result;
        return [$result, $orderID];
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

        if (!$cart) return response()->json(['message' => 'Cart is empty.'], 400);

        $totalPrice = $cart->total_price;
        // $totalDiscount = $cart->total_discount;
        $item_total = 0;
        $items = [];

        foreach ($cart->eBooks as $book) {
            $result = getBookBestDiscount($book);
            $discount = $result ? "{$result->discount}%" : 0;
            $items[] = [
                'id' => $book->id,
                'name' => "{$book->name} - {$book->edition}",
                'type' => 'Ebook',
                'url' => route('customer.book.detail', ['id' => $book->id]),
                'image_url' => app()->environment(['production']) ? $book->image : 'https://cdn1.polaris.com/globalassets/pga/accessories/my20-orv-images/no_image_available6.jpg',
                'quantity' => 1,
                'unit_amount' => [
                    'currency_code' => $this->paypalCurrency,
                    'value' => $book->fileCopy->price,
                ],
                'discount' => $discount,
            ];

            $item_total += $book->fileCopy->price;
        }

        foreach ($cart->hardCovers as $book) {
            $result = getBookBestDiscount($book);
            $discount = $result ? "{$result->discount}%" : 0;
            $items[] = [
                'id' => $book->id,
                'name' => "{$book->name} - {$book->edition}",
                'type' => 'Hardcover',
                'url' => route('customer.book.detail', ['id' => $book->id]),
                'image_url' => app()->environment(['production']) ? $book->image : 'https://cdn1.polaris.com/globalassets/pga/accessories/my20-orv-images/no_image_available6.jpg',
                'quantity' => getAmount($cart->id, $book->id),
                'unit_amount' => [
                    'currency_code' => $this->paypalCurrency,
                    'value' => $book->physicalCopy->price,
                ],
                'discount' => $discount,
            ];
            $item_total += $book->physicalCopy->price * getAmount($cart->id, $book->id);
        }

        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => Str::uuid(),
                    'amount' => [
                        'currency_code' => $this->paypalCurrency,
                        'value' => $totalPrice,
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => $this->paypalCurrency,
                                'value' => round($item_total,2),
                                // 'value' => round($totalPrice + $totalDiscount, 2),
                            ],
                            'tax_total' => [
                                'currency_code' => $this->paypalCurrency,
                                'value' => 0,
                            ],
                            'shipping' => [
                                'currency_code' => $this->paypalCurrency,
                                'value' => 0,
                            ],
                            'handling' => [
                                'currency_code' => $this->paypalCurrency,
                                'value' => 0,
                            ],
                            'insurance' => [
                                'currency_code' => $this->paypalCurrency,
                                'value' => 0,
                            ],
                            'shipping_discount' => [
                                'currency_code' => $this->paypalCurrency,
                                'value' => 0,
                            ],
                            'discount' => [
                                'currency_code' => $this->paypalCurrency,
                                'value' => round($item_total - $totalPrice, 2),
                                // 'value' => $totalDiscount,
                            ],
                        ],
                    ],
                    'items' => $items,
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

        $customerID = $token->tokenable_id;
        [$result, $cartID] = $this->purchase($customerID);
        if (!$result) {
            return response()->json(['message' => 'Failed to purchase cart.'], 500);
        }

        $orderID = $request->id;
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->getPaypalAccessToken()}",
            'Content-Type' => 'application/json',
        ])->withOptions([
            'verify' => false,
        ])->post("https://api-m.sandbox.paypal.com/v2/checkout/orders/{$orderID}/capture", ['json' => []]);

        if ($response->status() === 201) {
            DB::commit();
            $user = User::find($customerID);
            Mail::to($user->email)->queue(new PurchaseOrder($cartID));
            // $customerID = $token->tokenable_id;
            // if (!$this->purchase($customerID)) {
            //     return response()->json(['message' => 'Failed to purchase cart.'], 500);
            // }
        } else {
            DB::rollBack();
        }

        return $response;
    }

    public function show()
    {
        return view('customer.cart.index');
    }
}
