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
    return $this->belongsTo(Branch::class);
  }

}
