<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InjuryPart extends Model
{
    protected $guarded = [];

    public function matterinjuryparts()
    {
      return $this->hasMany(MatterInjuryPart::class);
    }
}
