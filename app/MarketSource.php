<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;

class MarketSource extends Model
{
    use Sluggable;
    //protected $guarded = [];
    protected $table = 'market_sources';

    protected $fillable = [
        'name', 'slug', 'remarks', 'status'
    ];

    protected $hidden = [
        'uuid',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function scopePublished($query) {
        return $query
                ->where('status', '=', 'yes');
    }

    public function sluggable()
     {
         return [
             'slug' => [
                 'source' => 'name'
             ]
         ];
     }

}
