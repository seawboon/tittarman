<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $guarded = [];

    public function scopePublished($query) {
        return $query->where('status','yes');
    }

    public function treatDrugs()
    {
      return $this->hasMany(TreatDrug::class);
    }

}
