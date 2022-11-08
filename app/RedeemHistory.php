<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
class RedeemHistory extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','redeem_id','status'
    ];

    public function user()
    {
         return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function redeemRequest()
    {
         return $this->hasOne('App\RedeemRequest', 'id', 'redeem_id');
    }

   
}


