<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentDiscount extends Model
{
    protected $guarded = [];
    
    public function payment()
    {
      return $this->belongsTo(Payment::class);
    }

    public function discountable()
{
    return $this->morphTo();
}
}
