<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ReviewRatingImage extends Model
{
    use SoftDeletes;

    public function reviewRating()
    {
        return $this->belongsTo('App\ReviewRating');
    }

    // public function getImageAttribute($value){
    //     if (Storage::disk('s3')->exists('images/review/'.$value) && $value){           
    //         return Storage::disk('s3')->url('images/review/' . $value);
    //     };
    //     return '';
    // }
}
