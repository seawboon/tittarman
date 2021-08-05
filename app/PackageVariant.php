<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;

class PackageVariant extends Model
{

    use SoftDeletes;
    use Sluggable;
    //protected $guarded = [];
    protected $table = 'package_variants';

    protected $fillable = [
        'name', 'sku', 'remark', 'status', 'stock', 'expiry', 'price', 'sell'
    ];

    protected $hidden = [
      'uuid'
    ];

    public function package()
    {
        //return $this->belongsToMany(Product::class);
        return $this->belongsTo(Package::class);
    }

    public function patientVariants()
    {
        return $this->hasMany(PatientPackage::class, 'variant_id');
    }

    public function vouchers()
    {
        return $this->hasMany(VariantVoucher::class, 'variant_id');
    }

    public function patientVouchers()
    {
        return $this->hasMany(VariantVoucher::class, 'variant_id');
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
            $model->position = PackageVariant::where('package_id', $model->package_id)->max('position') + 1;
        });
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
