<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentCollection extends Model
{
    protected $guarded = [];

    public function payment()
    {
      return $this->belongsTo(Payment::class);
    }

    public function collectable()
    {
        return $this->morphTo();
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

}
