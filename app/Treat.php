<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treat extends Model
{
  protected $guarded = [];

  public function matter()
  {
    return $this->belongsTo(Matter::class);
  }

  public function patient()
  {
    return $this->belongsTo(Patient::class);
  }

  public function branch()
  {
    return $this->belongsTo(Branches::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function products() {
    return $this->hasMany(TreatProduct::class);
  }

  public function images() {
    return $this->hasMany(Images::class, 'treat_id');
  }

  public function checkins()
  {
    return $this->hasMany(CheckIn::class);
  }

  public function payment()
  {
    return $this->hasOne(Payment::class, 'treat_id');
  }

}
