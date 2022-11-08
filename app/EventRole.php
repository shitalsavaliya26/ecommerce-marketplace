<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRole extends Model
{
    protected $fillable = [
       'event_id','role_id'
    ];


    public function event()
    {
         return $this->hasOne('App\Event', 'id', 'event_id');
    }

    public function role()
    {
         return $this->hasOne('App\Role', 'id', 'role_id');
    }

}
