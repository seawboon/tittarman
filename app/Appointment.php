<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = [];

    public function branch()
    {
      return $this->belongsTo(Branches::class, 'branch_id');
    }

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function matter()
    {
      return $this->belongsTo(Matter::class, 'matter_id');
    }

    public function patient()
    {
      return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function source()
    {
      return $this->belongsTo(AppointmentSource::class, 'source');
    }
}
