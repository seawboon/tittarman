<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatProduct extends Model
{
  protected $guarded = [];

  public function treat() {
    return $this->belongsTo(Treat::class);
  }

  public function payment() {
    return $this->belongsTo(Payment::class);
  }

}
