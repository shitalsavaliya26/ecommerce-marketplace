<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agentwithdrawrequest extends Model
{
    // Comment if project run on server
    // public function getDateFormat(){
    //     return 'Y-m-d H:i:s.u';
    // }  

    protected $table = "agent_withdraw_request";
    protected $fillable = [
        'user_id', 'account_number','bank_id','name','amount','securitypassword','reason','withdraw_request_from','status','pv_point'
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];

    public function user()
    {
    	return $this->hasOne('App\User','id','user_id');
    }

    public function bank()
    {
    	return $this->hasOne('App\Bank','id','bank_id');
    }

    public function gettransction_id()
    {
        return $this->hasOne('App\Transactionhistoriesagent','request_id','id')->select('transaction_id')->first();
    }
    public function printStatus($request)
    {

        if($request->status == 'pending')
        {
            return 'Pending';
        }
        elseif($request->status == 'accept')
        {
            return 'Accepted';
        }
        elseif($request->status == 'reject')
        {
            return 'Rejected';
        }
       else
       {
            return $request->status;
        }
    }

    public function getbankname()
    {
       return $this->hasOne('App\Bank','id','bank_id')->select('name')->first(); 
    }
}
