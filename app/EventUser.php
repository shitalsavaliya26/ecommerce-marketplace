<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    protected $fillable = [
        'event_id','user_id'
    ];


    public function event()
    {
         return $this->hasOne('App\Event', 'id', 'event_id');
    }

    public function user()
    {
         return $this->hasOne('App\User', 'id', 'user_id');
    }
}
