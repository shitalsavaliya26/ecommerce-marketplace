<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title','description','date_time'
    ];

    public function roles()
    {
         return $this->hasMany('App\EventRole', 'event_id', 'id')->select('role_id');
    }

    public function users()
    {
         return $this->hasMany('App\EventUser', 'event_id', 'id')->select('user_id');
    }

    public function rolelist()
    {
         return $this->hasMany('App\EventRole', 'event_id', 'id');
    }
    
    public function userlist()
    {
         return $this->hasMany('App\EventUser', 'event_id', 'id');
    }

    public function events()
    {
         return $this->hasMany('App\EventRole', 'event_id', 'id');
    }
}
