<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentSource extends Model
{
    protected $guarded = [];

    public function appointments()
    {
      return $this->hasMany(Appointment::class, 'source');
    }

}
