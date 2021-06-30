<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VariantVoucher extends Model
{
    protected $guarded = [];

    public function package()
    {
        //return $this->belongsToMany(Product::class);
        return $this->belongsTo(Package::class);
    }

    public function variant()
    {
        //return $this->belongsToMany(Product::class);
        return $this->belongsTo(PackageVariant::class);
    }

    public function type()
    {
        //return $this->belongsToMany(Product::class);
        return $this->belongsTo(VoucherType::class, 'voucher_type_id');
    }


    /*protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->total = $model->price * $model->unit;
        });
    }*/
}
