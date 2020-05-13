<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
  public function patient()
  {
    return $this->hasMany(Patient::class);
  }
}
