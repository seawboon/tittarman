<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function scopeShoponly($query) {
        return $query->where('shop','yes');
    }

    public function product()
    {
        return $this->belongsTo(PackageProduct::class);
    }
    
}
