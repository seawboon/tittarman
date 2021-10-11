<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopPromotionRule extends Model
{
    protected $guarded = [];

    protected $casts = [
          'config' => 'array'
    ];

    public static function types(){

        return array(
            'order_total'=>'Order Total',
            /*'promotion_items_total'=>'Promotion Items Total',
            'nth_order'=>'N Order',
            'has_category'=>'Category',
            'customer_group'=>'Customer Group',
            'item_quantity'=>'Item Quantity'*/
        );
    }

    public function promotion()
    {
        return $this->belongsTo(ShopPromotion::class);
    }


}
