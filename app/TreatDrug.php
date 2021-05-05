<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatDrug extends Model
{
    protected $guarded = [];

    public function treat()
    {
      return $this->belongsTo(Treat::class, 'treat_id');
    }

    public function drug()
    {
      return $this->belongsTo(Drug::class, 'drug_id');
    }

    public function parts()
    {
      return $this->hasMany(TreatDrugPart::class, 'treatdrug_id');
    }

}
