<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'content',
        'type',
        'product_id',
        'rate',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
