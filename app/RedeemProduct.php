<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
class RedeemProduct extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description','stock','image','term_condition'
    ];

    public function user()
    {
         return $this->hasOne('App\User', 'id', 'user_id');
    }

    

   
}


