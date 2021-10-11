<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matter extends Model
{
    protected $guarded = [];

    public function patient()
    {
      return $this->belongsTo(Patient::class);
    }

    public function injuries()
    {
      return $this->hasMany(MatterInjury::class, 'matter_id');
    }

    public function parts()
    {
      return $this->hasMany(MatterInjuryPart::class, 'matter_id');
    }

    public function treats()
    {
      return $this->hasMany(Treat::class);
    }

    public function images()
    {
      return $this->hasMany(Images::class, 'matter_id');
    }

    public function appointments()
    {
      return $this->hasMany(Appointment::class);
    }

    public function checkins()
    {
      return $this->hasMany(CheckIn::class);
    }

    public function payments()
    {
      return $this->hasMany(Payment::class, 'matter_id');
    }

}
