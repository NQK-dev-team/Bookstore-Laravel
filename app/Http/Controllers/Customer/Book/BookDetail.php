<?php

namespace App\Http\Controllers\Customer\Book;

use App\Models\Book;
use App\Models\Order;
use App\Models\Rating;
use voku\helper\AntiXSS;
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
        // return Rating::with('customer')->where('book_id', $id)->orderBy('updated_at', 'desc')->limit($numberOfRatings)->get(['users.name as customer_name', 'ratings.updated_at', 'ratings.star', 'ratings.comment']);

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

    public function show(Request $request)
    {
        $book = $this->getBook($request->id);
        if (!$book) {
            abort(404);
        }
        return view('customer.book.detail', ['book' => refineBookData($book)]);
    }
}
