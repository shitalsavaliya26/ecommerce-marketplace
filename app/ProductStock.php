<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','product_id','qty'
    ];

    public function user()
    {
         return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}


