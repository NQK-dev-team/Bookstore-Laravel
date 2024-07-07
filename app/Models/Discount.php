<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function eventDiscount(): HasOne
    {
        return $this->hasOne(EventDiscount::class, 'id', 'id');
    }

    public function refererrDiscount(): HasOne
    {
        return $this->hasOne(ReferrerDiscount::class, 'id', 'id');
    }

    public function customerDiscount(): HasOne
    {
        return $this->hasOne(CustomerDiscount::class, 'id', 'id');
    }
}
