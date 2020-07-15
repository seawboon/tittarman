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
      return $this->belongsTo(Matter::class);
    }

    public function branch()
    {
      return $this->belongsTo(Branches::class, 'branch_id');
    }

    public function treat()
    {
      return $this->belongsTo(Treat::class);
    }

    public function products() {
      return $this->hasMany(PaymentProduct::class);
    }

}
