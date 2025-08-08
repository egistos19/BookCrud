<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ImportStatus;

class ImportHistory extends Model
{
    protected $fillable = ['filename', 'status'];
    protected $casts = ['status' => ImportStatus::class,];
}
