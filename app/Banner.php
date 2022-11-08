<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use SoftDeletes;
    protected $hidden = ['created_at','updated_at'];
    

    // public function getImageAttribute($value)
    // {
    //     if (Storage::disk('s3')->exists('images/banner/' . $value) && $value) {
    //         return Storage::disk('s3')->url('images/banner/' . $value);
    //     };
    //     return '';
    // }

    public function bannerType()
    {
        return $this->belongsTo(BannerType::class);
    }

    public function bannerImages()
    {
        return $this->hasMany(BannerImage::class);
    }
}
