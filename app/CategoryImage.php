<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CategoryImage extends Model
{
    //
    protected $table = 'category_images';

    protected $fillable = [
        'image',
    ];

    protected $hidden = array('created_at', 'updated_at');
    protected $appends = array('image_url');

    public function category()
    {
        return $this->belongsTo('App\Category')->where('status', 'active')->where('is_deleted','0');
    }

    public function activecategory()
    {
        return $this->hasOne('App\Category', 'category_id')->where('status', 'active')->where('is_deleted','0')->with('image');
    }

    public function getImageUrlAttribute($value)
    {
        if (file_exists(public_path('images/category/' . $this->image)) && $this->image) {
            return asset('public/images/category/' . $this->image);
        }
        return '';
    }

    // public function getImageAttribute($value)
    // {
    //     if (Storage::disk('s3')->exists('images/category/' . $value) && $value) {
    //         return Storage::disk('s3')->url('images/category/' . $value);
    //     };
    //     return '';
    // }
}
