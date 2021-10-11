<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageVariantRedeemLocation extends Model
{
    protected $guarded = [];

    public function variant()
    {
      return $this->belongsTo(VariantVoucher::class);
    }

    public function branch()
    {
      return $this->belongsTo(Branches::class);
    }

}
