<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;

class Package extends Model
{
    use SoftDeletes;
    use Sluggable;
    //protected $guarded = [];
    protected $table = 'packages';

    protected $fillable = [
        'title', 'description', 'total', 'sell', 'percentage', 'status', 'publish_date_start', 'publish_date_end'
    ];

    protected $appends = ['web_image_url'];

    protected $hidden = [
      'uuid'
    ];

    function getWebImageUrlAttribute() {
      if(is_null($this->image_url)) {
        return asset('image/loginlogo.png');
      } else {
        return asset('storage/'.$this->image_url);
      }
    }

    public function products()
    {
        return $this->hasMany(PackageProduct::class);
    }

    public function scopePublishedDate($query) {
        return $query
                ->whereDate('publish_date_start', '<=', now())
                ->whereDate('publish_date_end', '>=', now());
    }

    public function scopePublished($query) {
        return $query
                ->where('status', '=', 'yes');
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function sluggable()
     {
         return [
             'slug' => [
                 'source' => 'title'
             ]
         ];
     }

}
