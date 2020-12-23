<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = [];

    public function patient()
    {
      return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function branch()
    {
      return $this->belongsTo(Branches::class, 'branch_id');
    }
}
