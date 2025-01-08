<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'offer_id',
        'store_id',
    ];
}
