<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class PatientVoucher extends Model
{
    protected $guarded = [];

    //protected $appends = ['expiry_on'];

    public function patientPackage()
    {
      return $this->belongsTo(PatientPackage::class, 'patient_package_id');
    }

    public function patient()
    {
      return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function type()
    {
      return $this->belongsTo(VoucherType::class, 'voucher_type_id');
    }

    public function claimBy()
    {
      return $this->belongsTo(Patient::class, 'claim_by');
    }

    public function useInPayment()
    {
      return $this->belongsTo(Payment::class, 'use_in_payment');
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
