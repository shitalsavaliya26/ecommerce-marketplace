<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image'
    ];

    public function user()
    {
         return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function activeproduct()
    {
        return $this->hasOne('App\Product','id','product_id')->with('image');
    }

    
    // public function getImageAttribute($value){
    //     if (Storage::disk('s3')->exists('images/product/'.$value) && $value){           
    //         return Storage::disk('s3')->url('images/product/' . $value);
    //     };
    //     return '';
    // }
}


