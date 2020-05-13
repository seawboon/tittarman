<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class injury extends Model
{
    public function matterinjury()
    {
      return $this->hasMany(MatterInjury::class);
    }
}
