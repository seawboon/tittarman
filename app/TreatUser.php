<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatUser extends Model
{
    protected $guarded = [];

    public function treat()
    {
      return $this->belongsTo(Treat::class, 'treat_id');
    }

    public function master()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

}
