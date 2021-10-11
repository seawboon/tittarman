<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopPromotionAction extends Model
{
    protected $guarded = [];

    protected $casts = [
          'config' => 'array'
    ];

    public static function types(){

        return array(
            'order_fixed_discount'=>'Order Fixed Discount',
            /*'order_percentage_discount'=>'Order Percentage Discount',
            'promotion_items_fixed_discount'=>'Promotion Items Fixed Discount',
            'promotion_items_ladder_discount'=>'Promotion Items Ladder Discount',
            'present_integral'=>'Present Integral',
            'shipping_percentage_discount'=>'Shipping Percentage Discount',
            'free_shipping'=>'Free Shipping'*/
        );
    }

    public function promotion()
    {
        return $this->belongsTo(ShopPromotion::class);
    }
}
