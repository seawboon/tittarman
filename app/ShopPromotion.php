<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopPromotion extends Model
{
    protected $table = 'shop_promotions';
    protected $fillable = [
        'code', 'name', 'description', 'cover', 'asset_url', 'position', 'type', 'config', 'began_at', 'ended_at'
    ];
    protected $appends = ['status'];

    public static function types(){

        return array(
            'coupon' => 'Coupon',
            'flexi' => 'Flexible',
            /*'general'=>'General',
            'group'=>'Group',
            'brand'=>'Brand',
            'full_discount'=>'Full Discount'*/
        );
    }

    public function discounts()
    {
        return $this->morphMany(PaymentDiscount::class, 'discountable');
    }

    public function rule()
    {
      return $this->hasOne(ShopPromotionRule::class, 'promotion_id');
    }

    public function action()
    {
      return $this->hasOne(ShopPromotionAction::class, 'promotion_id');
    }

    public function variant()
    {
      return $this->hasOne(ShopPromotionVariant::class, 'promotion_id');
    }

    function getStatusAttribute() {
      if($this->began_at <= now()) {
        if($this->ended_at >= now()) {
          return 'active';
        } else {
          return 'expired';
        }
      } else {
        return 'Coming soon';
      }
    }


    public function scopeActive($query) {
        return $query
                ->whereDate('began_at', '<=', now())
                ->whereDate('ended_at', '>=', now());
    }

}
