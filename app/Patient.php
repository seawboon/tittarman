<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Patient extends Model
{
    protected $guarded = [];

    public function branch()
    {
      return $this->belongsTo(Branches::class);
    }

    public function matters()
    {
      return $this->hasMany(Matter::class);
    }

    public function treats()
    {
      return $this->hasMany(Treat::class);
    }

    public function LastTreat()
    {
      return $this->hasOne(Treat::class)->with('branch')->orderBy('treat_date', 'desc');
    }

    public function checkins()
    {
      return $this->hasMany(CheckIn::class);
    }

    public function appointments()
    {
      return $this->hasMany(Appointment::class);
    }

    public function payments()
    {
      return $this->hasMany(Payment::class, 'patient_id');
    }

    public function vouchers()
    {
      return $this->hasMany(Voucher::class, 'patient_id');
    }

    public function AvailabelVoucher()
    {
      //return $this->hasMany(Voucher::class, 'patient_id');
      return $this->vouchers()->where('state','enable');
    }

    public function transfers()
    {
      return $this->hasMany(Voucher::class, 'owner_id');
    }

    public function accounts()
    {
      return $this->hasMany(Account::class, 'patient_id');
    }


}
