<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'Name',
        'Email',
        'id',
        'Location',
        'Services',
        'Phone',
        'Link_Website',
        'About_Store',
    
    ];

    public function User() {
        return $this->belongsTo('App\Models\User');
    }


    public function Photo() {
        return $this->morphOne('App\Models\Photo', 'photoable');
    }

    public function Categories() {
        return $this->belongsToMany('App\Models\Category');
    }


}
