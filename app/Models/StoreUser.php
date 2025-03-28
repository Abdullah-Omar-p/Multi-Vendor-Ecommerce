<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'store_id',
    ];
}
