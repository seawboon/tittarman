<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
  protected $guarded = [];

  public function matter()
  {
    return $this->belongsTo(Matter::class);
  }

  public function treat()
  {
    return $this->belongsTo(Treat::class);
  }

}
