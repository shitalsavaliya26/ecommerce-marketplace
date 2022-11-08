<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewRating extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function reviewRatingImages()
    {
        return $this->hasMany('App\ReviewRatingImage');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function reviewRatingVotes()
    {
        return $this->hasMany('App\ReviewRatingVote');
    }

}
