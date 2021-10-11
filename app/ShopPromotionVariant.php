<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopPromotionVariant extends Model
{
    protected $guarded = [];

    public function promotion()
    {
        return $this->belongsTo(ShopPromotion::class);
    }
}
