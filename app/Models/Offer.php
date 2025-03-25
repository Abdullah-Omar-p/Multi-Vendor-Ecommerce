<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'price',
        'about',
        'custom',
        'status',
        'no_pieces',
        'store_id',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'offer_products');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'offer_users');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
