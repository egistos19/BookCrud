<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
        protected $fillable = [
        'name',
        'author',
        'isbn',
        'cover_image',
        ];
}
