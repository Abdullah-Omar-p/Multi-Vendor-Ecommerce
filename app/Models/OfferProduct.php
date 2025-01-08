<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'offer_id',
        'product_id',
        'store_id',
    ];
}
