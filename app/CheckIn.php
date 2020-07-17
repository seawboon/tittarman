<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
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

    public function matter()
    {
      return $this->belongsTo(Matter::class, 'matter_id');
    }

    public function treat()
    {
      return $this->belongsTo(Treat::class, 'treat_id');
    }

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

}
