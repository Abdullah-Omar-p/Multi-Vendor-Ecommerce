<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'price',
        'status',
        'store_id',
        'user_id',
        'trans_date',
//        'offer_id',
        'location',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')->withTimestamps();
    }
}
