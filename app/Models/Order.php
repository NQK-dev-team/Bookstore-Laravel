<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

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

    public function physicalOrder(): HasOne
    {
        return $this->hasOne(PhysicalOrder::class, 'id', 'id');
    }

    public function fileOrder(): HasOne
    {
        return $this->hasOne(FileOrder::class, 'id', 'id');
    }

    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class, 'discount_applies_to', 'order_id', 'discount_id');
    }
}
