<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
  protected $table = 'states';

  protected $fillable = ['name'];


  public function country()
  {
      return $this->belongsTo('App\Country', 'country_id');
  }
}
