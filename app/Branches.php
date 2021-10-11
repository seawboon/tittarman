<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
  public function patient()
  {
    return $this->hasMany(Patient::class);
  }

  public function treats()
  {
    return $this->hasMany(Treat::class);
  }

  public function checkins()
  {
    return $this->hasMany(CheckIn::class);
  }

  public function appointments()
  {
    return $this->hasMany(Appointment::class, 'branch_id');
  }

  public function payments()
  {
    return $this->hasMany(Payment::class, 'branch_id');
  }

  public function accounts()
  {
    return $this->hasMany(Account::class, 'branch_id');
  }

  public function variantRedeemLocations()
  {
    return $this->hasMany(PackageVariantRedeemLocation::class, 'branch_id');
  }

}
