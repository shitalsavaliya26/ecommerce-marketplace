<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentVerification extends Model
{
    public function user()
    {
         return $this->hasOne('App\User', 'id', 'agent_id');
    }

    public function media()
    {
         return $this->hasMany('App\AgentVerificationMedia', 'verification_id', 'id');
    }

}
