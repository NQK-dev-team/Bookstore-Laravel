<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ratings';

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = []; // Using this line means that every column in the table can be mass assigned.

    // public function customer(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'customer_id', 'id');
    // }

    // public function book(): BelongsTo
    // {
    //     return $this->belongsTo(Book::class, 'book_id', 'id');
    // }
}
