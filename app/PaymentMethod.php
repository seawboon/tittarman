<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $guarded = [];

    public function payments()
    {
      return $this->hasMany(Payment::class, 'method_id');
    }

    public function collections()
    {
      return $this->hasMany(PaymentCollection::class, 'payment_method_id');
    }
}
