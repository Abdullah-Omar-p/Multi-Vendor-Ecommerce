<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;


    protected $fillable = [
      'id',
      'user_id',
    ];


    public function Products()
    {
        return $this->belongsToMany(Product::class,'cart_products');
    }
}
