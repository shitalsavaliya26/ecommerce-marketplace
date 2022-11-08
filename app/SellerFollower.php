<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerFollower extends Model
{
    /**
     * Get the phone record associated with the user.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'customer_id');
    }
}
