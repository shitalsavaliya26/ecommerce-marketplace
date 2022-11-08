<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewRatingVote extends Model
{
    public function reviewRating()
    {
        return $this->belongsTo('App\ReviewRating');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
