<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherType extends Model
{
    protected $guarded = [];

    public function scopePublished($query) {
        return $query
                ->where('status', '=', 'yes');
    }

    public function variantVoucher()
    {
      return $this->belongsTo(VariantVoucher::class);
    }

    public function patientVoucher()
    {
      return $this->hasMany(PatientVoucher::class);
    }
}
