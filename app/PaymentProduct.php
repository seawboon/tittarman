<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentProduct extends Model
{
  protected $guarded = [];

  public function treat() {
    return $this->belongsTo(Treat::class);
  }

  public function patient() {
    return $this->belongsTo(Patient::class);
  }

  public function matter() {
    return $this->belongsTo(Matter::class);
  }

  public function payment() {
    return $this->belongsTo(Payment::class);
  }
}
