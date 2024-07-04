<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    public function physicalCopy(): HasOne
    {
        return $this->hasOne(PhyiscalCopy::class, 'id', 'id');
    }

    public function fileCopy(): HasOne
    {
        return $this->hasOne(FileCopy::class, 'id', 'id');
    }

    public function categories(): BelongsToMany
    {
        return $this->BelongsToMany(Category::class, 'belongs_to', 'book_id', 'category_id');
    }

    public function authors(): HasMany
    {
        return $this->hasMany(Author::class, 'book_id', 'id');
    }
}
