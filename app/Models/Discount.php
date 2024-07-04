<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discount extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'discounts';

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    public function eventDiscounts(): HasMany
    {
        return $this->hasMany(EventDiscount::class, 'id', 'id');
    }

    public function refererrDiscount(): HasMany
    {
        return $this->hasMany(ReferrerDiscount::class, 'id', 'id');
    }

    public function customerDiscount(): HasMany
    {
        return $this->hasMany(CustomerDiscount::class, 'id', 'id');
    }
}
