<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'Name',
        'Col_1',
        'Col_2',
        'Col_3',
        'Col_4',
        'Description',
        'id',
        'About',
        'Color',
        'Buy',
        'Ordering',
        'Brand',
        'Parent',
        'Price',
        'Available_Pieces',
        'Discount',
        'Wieght',
    ];
    
    
    public function Orders()
{
    return $this->hasMany('App\Models\Order');
}
    
public function Stores() {
    return $this->belongsToMany('App\Models\Store');
}
    
public function Photos()
{
    return $this->hasMany('App\Models\Photo');
}   

public function Comments()
{
    return $this->hasMany('App\Models\Comments');
}

}
