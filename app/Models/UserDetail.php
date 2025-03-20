<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'image'
    ];

   
}
