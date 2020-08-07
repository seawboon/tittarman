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
}
