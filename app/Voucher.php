<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
      'code'
    ];

    public function patient()
    {
      return $this->belongsTo(Patient::class);
    }

    public function payment()
    {
      return $this->belongsTo(Payment::class);
    }
}
