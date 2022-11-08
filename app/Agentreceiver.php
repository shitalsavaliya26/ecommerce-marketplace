<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agentreceiver extends Model
{
    //  Uncomment this code when project runs in local
    // protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $hidden = ['created_at','updated_at'];

    protected $fillable = [
        'agent_id', 'name','contact_no','address_line1','address_line2','state','town','postal_code','country','countrycode','is_deleted','address_for', 'created_at', 'updated_at', 'current_address', 'is_default'
    ];
}
