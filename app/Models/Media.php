<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'mediaable' ;

    protected $fillable = [
        'filename',
        'mediaable_id',
        'mediaable_type',
        'type',
    ];

}
