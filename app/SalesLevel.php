<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesLevel extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'user_id'
    ];

    public function user()
    {
         return $this->hasMany('App\User', 'id', 'sale_level');
    }
}


