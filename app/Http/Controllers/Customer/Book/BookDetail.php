<?php

namespace App\Http\Controllers\Customer\Book;

use Exception;
use App\Models\Book;
use App\Models\Order;
use App\Models\Rating;
use voku\helper\AntiXSS;
use App\Models\FileOrder;
use Illuminate\Http\Request;
use App\Models\PhysicalOrder;
use App\Models\FileOrderContain;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PhysicalOrderContain;
use Illuminate\Database\Eloquent\Builder;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class BookDetail extends Controller
{
    public function getBook($id)
    {
        return Book::with(['categories', 'authors', 'physicalCopy', 'fileCopy'])->where('status', true)->find($id);
    }

    public function checkCustomerBoughtBook($id)
    {
        if (!auth()->check()) {
            return false;
        }
        $result = Order::orWhereHas('physicalOrder.physicalCopies', function (Builder $query) use ($id) {
            $query->where('physical_copies.id', $id);
        })->orWhereHas(
            'fileOrder.fileCopies',
            function (Builder $query) use ($id) {
                $query->where('file_copies.id', $id);
            }
        )->where([
            ['customer_id', '=', auth()->id()],
            ['status', '=', 'true']
        ])->exists();

        return $result;
    }

    public function getCustomerRating($id)
    {
        if (!auth()->check()) {
            return null;
        }

        return Rating::where([
            ['customer_id', '=', auth()->id()],
            ['book_id', '=', $id]
        ])->first();
    }

    public function submitRating($book_id, $rating, $comment)
    {
        if (!auth()->check()) {
            abort(401);
        }

        $antiXss = new AntiXSS();

        DB::transaction(function () use ($book_id, $rating, $comment, $antiXss) {
            if (Rating::where([
                ['customer_id', '=', auth()->id()],
                ['book_id', '=', $book_id]
            ])->exists())
                Rating::where([
                    ['customer_id', '=', auth()->id()],
                    ['book_id', '=', $book_id]
                ])->update(
                    ['star' => $antiXss->xss_clean($rating), 'comment' => $comment ? $antiXss->xss_clean($comment) : null],
                );
            else
                Rating::create([
                    'customer_id' => auth()->id(),
                    'book_id' => $book_id,
                    'star' => $antiXss->xss_clean($rating),
                    'comment' => $comment ? $antiXss->xss_clean($comment) : null
                ]);

            $new_average_rating = Rating::where('book_id', $book_id)->avg('star');
            Book::where([
                ['id', '=', $book_id],
            ])->update(['average_rating' => $new_average_rating ? $new_average_rating : 0]);
        });
    }

    public function deleteRating($id)
    {
        if (!auth()->check()) {
            abort(401);
        }

        DB::transaction(function () use ($id) {
            Rating::where([
                ['customer_id', '=', auth()->id()],
                ['book_id', '=', $id]
            ])->delete();

            $new_average_rating = Rating::where('book_id', $id)->avg('star');
            Book::where([
                ['id', '=', $id],
            ])->update(['average_rating' => $new_average_rating ? $new_average_rating : 0]);
        });
    }

    public function isRatingExist($id)
    {
        return Rating::where([
            ['book_id', '=', $id]
        ])->exists();
    }

    public function getRatings($id, $numberOfRatings, $filter)
    {
        if (!$filter)
            return Rating::where('book_id', $id)
                ->orderBy('updated_at', 'desc')
                ->limit($numberOfRatings)
                ->join('users', 'users.id', '=', 'ratings.customer_id')
                ->get(['users.name', 'users.image', 'ratings.updated_at', 'ratings.star', 'ratings.comment']);

        return Rating::where('book_id', $id)
            ->orderBy('updated_at', 'desc')
            ->limit($numberOfRatings)
            ->join('users', 'users.id', '=', 'ratings.customer_id')
            ->where([
                ['ratings.star', '=', $filter],
            ])
            ->get(['users.name', 'users.image', 'ratings.updated_at', 'ratings.star', 'ratings.comment']);
    }

    public function addPhysicalToCart($id, $amount)
    {
        if (!auth()->check()) {
            abort(401);
        }

        $order = Order::select('id')->where([
            ['customer_id', '=', auth()->id()],
            ['status', '=', 'false']
        ])->first();

        DB::transaction(function () use ($id, $amount, $order) {
            if (!$order) {
                $order = Order::create([
                    'id' => IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'O-']),
                    'customer_id' => auth()->id()
                ]);
            }
            $orderID = $order->id;

            if (!PhysicalOrder::where('id', $orderID)->exists())
                PhysicalOrder::create([
                    'id' => $orderID,
                    'address' => auth()->user()->address,
                ]);

            $result = PhysicalOrderContain::where([
                ['order_id', '=', $orderID],
                ['book_id', '=', $id]
            ])->first();

            if ($result) {
                $amount += $result->amount;

                PhysicalOrderContain::where([
                    ['order_id', '=', $orderID],
                    ['book_id', '=', $id]
                ])->update(['amount' => $amount]);
            } else {
                PhysicalOrderContain::create([
                    'order_id' => $orderID,
                    'book_id' => $id,
                    'amount' => $amount,
                ]);
            }

            // Re-calculate the order total price and total discount values
            if (!recalculateOrderValue($orderID)) {
                throw new Exception('Failed to recalculate order.');
            }
        });

        return 0;
    }

    public function addFileToCart($id)
    {
        if (!auth()->check()) {
            abort(401);
        }

        $check = Order::whereHas(
            'fileOrder.fileCopies',
            function (Builder $query) use ($id) {
                $query->where('file_copies.id', $id);
            }
        )->where([
            ['customer_id', '=', auth()->id()],
            ['status', '=', 'true']
        ])->exists();

        if ($check)
            return 1;

        $check = Order::whereHas(
            'fileOrder.fileCopies',
            function (Builder $query) use ($id) {
                $query->where('file_copies.id', $id);
            }
        )->where([
            ['customer_id', '=', auth()->id()],
            ['status', '=', 'false']
        ])->exists();

        if ($check)
            return 2;

        $order = Order::select('id')->where([
            ['customer_id', '=', auth()->id()],
            ['status', '=', 'false']
        ])->first();

        DB::transaction(function () use ($id, $order) {
            if (!$order) {
                $order = Order::create([
                    'id' => IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'O-']),
                    'customer_id' => auth()->id()
                ]);
            }
            $orderID = $order->id;

            if (!FileOrder::where('id', $orderID)->exists())
                FileOrder::create([
                    'id' => $orderID,
                ]);

            FileOrderContain::create([
                'order_id' => $orderID,
                'book_id' => $id,
            ]);

            // Re-calculate the order total price and total discount values
            if (!recalculateOrderValue($orderID)) {
                throw new Exception('Failed to recalculate order.');
            }
        });

        return 0;
    }

    public function show(Request $request)
    {
        $book = $this->getBook($request->id);
        if (!$book) {
            abort(404);
        }
        return view('customer.book.detail', ['book' => refineBookData($book)]);
    }
}
