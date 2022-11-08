<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderNote extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','order_id', 'note','status'
    ];

    public function user()
    {
         return $this->hasOne('App\Order', 'id', 'order_id');
    }

}


