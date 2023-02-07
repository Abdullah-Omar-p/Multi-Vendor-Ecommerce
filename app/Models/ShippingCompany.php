<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCompany extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'Name',
        'Email',
        'id',
        'Location',
        'Phone',
        'Website',
        'Address',
    ];

    public function Photo() {
        return $this->morphOne('App\Models\Photo', 'photoable');
    }

    public function Orders()
{
    return $this->hasMany('App\Models\Order');
}


}
