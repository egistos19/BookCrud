<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = [
    'name',
    'author_id',
    'isbn',
    'cover_image',
    ];
    protected $casts = ['author_id' => 'integer',];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
    public function bookstores(): BelongsToMany
    {
        return $this->belongsToMany(Bookstore::class);
    }
}
