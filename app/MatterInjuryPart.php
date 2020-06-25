<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatterInjuryPart extends Model
{
  protected $guarded = [];

  public function matter()
  {
    return $this->belongsTo(MatterInjuryPart::class, 'matter_id');
  }

  public function part()
  {
    return $this->belongsTo(InjuryPart::class, 'injury_part_id');
  }
}
