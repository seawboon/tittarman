<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatDrugPart extends Model
{
    protected $guarded = [];

    public function treat()
    {
      return $this->belongsTo(Treat::class, 'treat_id');
    }

    public function treatDrug()
    {
      return $this->belongsTo(TreatDrug::class, 'treatdrug_id');
    }
}
