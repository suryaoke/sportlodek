<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
class Merchant extends Model
{

    protected $fillable = [
        'user_id',
        'name',
        'about',
        'address',
        'image',
        'slug',
    ];

    public static function boot()
    {
        parent::boot();

        // Buat slug saat data baru dibuat
        static::creating(function ( $merchant) {
             $merchant->slug = Str::slug( $merchant->name);
        });

        // Update slug ketika name diubah
        static::updating(function ( $merchant) {
            if ( $merchant->isDirty('name')) {
                 $merchant->slug = Str::slug( $merchant->name);
            }
        });
    }
    function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function merchantDetail(): HasMany
    {
        return $this->hasMany(MerchantDetail::class, 'id', 'merchant_id');
    }
}
