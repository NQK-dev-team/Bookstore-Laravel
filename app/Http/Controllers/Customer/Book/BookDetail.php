<?php

namespace App\Http\Controllers\Customer\Book;

use App\Models\Book;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class BookDetail extends Controller
{
    private function getBook($id)
    {
        return Book::with(['categories', 'authors', 'physicalCopy', 'fileCopy'])->find($id);
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
        DB::transaction(function () use ($book_id, $rating, $comment) {
            if (Rating::where([
                ['customer_id', '=', auth()->id()],
                ['book_id', '=', $book_id]
            ])->exists())
                Rating::where([
                    ['customer_id', '=', auth()->id()],
                    ['book_id', '=', $book_id]
                ])->update(
                    ['star' => $rating, 'comment' => $comment],
                );
            else
                Rating::create([
                    'customer_id' => auth()->id(),
                    'book_id' => $book_id,
                    'star' => $rating,
                    'comment' => $comment
                ]);
        });
    }

    public function deleteRating($id)
    {
        DB::transaction(function () use ($id) {
            Rating::where([
                ['customer_id', '=', auth()->id()],
                ['book_id', '=', $id]
            ])->delete();
        });
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
