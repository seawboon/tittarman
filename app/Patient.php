<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon;

class Patient extends Model
{

    protected $guarded = [];

    protected $hidden = [
        'uuid',
    ];

    protected $appends = ['age', 'mv', 'ark', '1u'];

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

    public function packages()
    {
      return $this->hasMany(PatientPackage::class, 'patient_id');
    }

    public function vouchers()
    {
      return $this->hasMany(PatientVoucher::class, 'patient_id');
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

    /*public function getPhoneAttribute()
    {
        return $this->provider.$this->contact;
    }*/

    public function getAgeAttribute()
    {
        //return $this->provider.$this->contact;
        return Carbon\Carbon::parse($this->dob)->age;
    }

    public function getMvAttribute()
    {
        //return $this->provider.$this->contact;
        $account = Account::select('account_no')->where('patient_id', $this->id)->where('branch_id', 1)->first();
        return $account['account_no'];
    }

    public function getArkAttribute()
    {
        //return $this->provider.$this->contact;
        $account = Account::select('account_no')->where('patient_id', $this->id)->where('branch_id', 2)->first();
        return $account['account_no'];
    }

    public function get1uAttribute()
    {
        //return $this->provider.$this->contact;
        $account = Account::select('account_no')->where('patient_id', $this->id)->where('branch_id', 3)->first();
        return $account['account_no'];
    }

}
