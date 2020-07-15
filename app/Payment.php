<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public function patient()
    {
      return $this->belongsTo(Patient::class);
    }

    public function matter()
    {
      return $this->belongsTo(matter::class);
    }

    public function treat()
    {
      return $this->belongsTo(Treat::class);
    }

    public function products() {
      return $this->hasMany(PaymentProduct::class);
    }

}
