<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'about_store',
        'phone',
        'link_website',
        'services',
        'location',
        'email',
    ];
    public function admins()
    {
        return $this->belongsToMany(User::class , 'store_users');
    }
}
