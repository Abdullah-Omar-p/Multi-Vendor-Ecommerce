<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'comment_id',
        'rate',
    ];

    public function comment()
    {
        return $this->hasOne(Comment::class);
    }
}
