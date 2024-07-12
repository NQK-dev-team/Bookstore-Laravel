<?php

namespace App\Observers;

use App\Models\Book;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class RatingObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Rating "created" event.
     */
    public function created(Rating $rating): void
    {
        $new_average_rating = Rating::where('book_id', $rating->book_id)->avg('star');
        DB::transacation(function () use ($rating, $new_average_rating) {
            Book::where([
                ['id', '=', $rating->book_id],
            ])->update(['average_rating' => $new_average_rating]);
        });
    }

    /**
     * Handle the Rating "updated" event.
     */
    public function updated(Rating $rating): void
    {
        $new_average_rating = Rating::where('book_id', $rating->book_id)->avg('star');
        DB::transacation(function () use ($rating, $new_average_rating) {
            Book::where([
                ['id', '=', $rating->book_id],
            ])->update(['average_rating' => $new_average_rating]);
        });
    }

    /**
     * Handle the Rating "deleted" event.
     */
    public function deleted(Rating $rating): void
    {
        $new_average_rating = Rating::where('book_id', $rating->book_id)->avg('star');
        DB::transacation(function () use ($rating, $new_average_rating) {
            Book::where([
                ['id', '=', $rating->book_id],
            ])->update(['average_rating' => $new_average_rating]);
        });
    }

    /**
     * Handle the Rating "restored" event.
     */
    public function restored(Rating $rating): void
    {
        //
    }

    /**
     * Handle the Rating "force deleted" event.
     */
    public function forceDeleted(Rating $rating): void
    {
        //
    }
}
