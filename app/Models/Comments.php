<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $fillable = [
        'Body',
        'Parent',        
        'id',
        
    ];

    public function User()
    {
     return $this->belongsTo('App\Models\User');
    }

    public function Category()
    {
     return $this->belongsTo('App\Models\Category');
    }
}
