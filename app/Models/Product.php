<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'price',
        'discount',
        'available_pieces',
        'weight',
        'color',
        'col_1',
        'sold',
        'rate',
        'description',
        'col_2',
        'col_3',
        'col_4',
        'about',
        'name',
        'brand',
        'store_id',
        'category_id',
        'added_by',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')->withTimestamps();
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }
}
