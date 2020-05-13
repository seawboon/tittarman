<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Patient extends Model
{
    protected $guarded = [];

    public function branch()
    {
      return $this->belongsTo(Branches::class);
    }

    public function matters()
    {
      return $this->hasMany(Matter::class);
    }

    public function treats()
    {
      return $this->hasMany(Treat::class);
    }
}
