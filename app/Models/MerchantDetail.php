<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantDetail extends Model
{
    protected $fillable = [
        'merchant_id',
        'name',
        'desc',
        'status',
        'open',
        'close',
        'type',
    ];
}
