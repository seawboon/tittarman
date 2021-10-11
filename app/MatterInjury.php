<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatterInjury extends Model
{
  protected $guarded = [];

  public function matter()
  {
    return $this->belongsTo(Matter::class, 'matter_id');
  }

  public function injury()
  {
    return $this->belongsTo(injury::class, 'injury_id');
  }

}
