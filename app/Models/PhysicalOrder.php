<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PhysicalOrder extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'physical_orders';

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

    public function physicalCopies(): BelongsToMany
    {
        return $this->belongsToMany(PhyiscalCopy::class, 'physical_order_contains', 'order_id', 'book_id')->withPivot('amount');
    }
}
