<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public function patient()
    {
      return $this->belongsTo(Patient::class);
    }

    public function matter()
    {
      return $this->belongsTo(Matter::class);
    }

    public function branch()
    {
      return $this->belongsTo(Branches::class, 'branch_id');
    }

    public function treat()
    {
      return $this->belongsTo(Treat::class);
    }

    public function products() {
      return $this->hasMany(PaymentProduct::class);
    }

    public function vouchers()
    {
      return $this->hasMany(Voucher::class, 'payment_id');
    }

    public function PatientPackage()
    {
      return $this->hasOne(PatientPackage::class, 'payment_id');
    }

    public function method()
    {
      return $this->belongsTo(PaymentMethod::class, 'method_id');
    }

    public function UsedVoucher()
    {
      return $this->hasOne(PatientVoucher::class, 'use_in_payment');
    }

}
