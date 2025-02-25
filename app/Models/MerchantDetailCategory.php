<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantDetailCategory extends Model
{
    protected $fillable = [
        'merchant_detail_id',
        'name',
        'price',
    ];
}
