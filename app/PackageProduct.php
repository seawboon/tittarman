<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageProduct extends Model
{
    protected $guarded = [];

    public function package()
    {
        //return $this->belongsToMany(Product::class);
        return $this->belongsTo(Package::class);
    }

    public function product()
    {
        //return $this->belongsToMany(Product::class);
        return $this->belongsTo(Product::class);
    }


    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->total = $model->price * $model->unit;
        });
    }

}
