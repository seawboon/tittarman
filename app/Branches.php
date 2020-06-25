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

}
