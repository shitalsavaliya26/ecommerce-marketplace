<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agentdepositcancelrequest extends Model
{
    protected $table = "agent_deposit_cancel_request";

    protected $fillable = [
        'user_id', 'request_id','reason'
    ];
}
