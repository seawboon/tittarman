<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class PatientPackage extends Model
{
    protected $guarded = [];

    public function patient()
    {
      return $this->belongsTo(Patient::class);
    }

    public function package()
    {
      return $this->belongsTo(Package::class, 'package_id');
    }

    public function variant()
    {
      return $this->belongsTo(PackageVariant::class);
    }

    public function payment()
    {
      return $this->belongsTo(Payment::class);
    }

    public function patientVouchers()
    {
      return $this->hasMany(PatientVoucher::class);
    }



    function getDateAttribute() {
      return Carbon::parse($this->created_at)->format('d M Y');
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
