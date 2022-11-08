<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agentdepositrequest extends Model
{

	protected $table = "agent_deposit_request";
    protected $fillable = [
        'user_id', 'amount','securitypassword','status','receipt_path','to_accountname','to_accountnumber','to_bank', 'wallet_amount'
    ];

    public function user()
    {
    	return $this->hasOne('App\User','id','user_id');
    }

    public function cancelrequest()
    {
    	return $this->hasOne('App\Agentdepositcancelrequest','request_id','id');
    }

    public function getreceiptpath($value)
    {
        return url('public').'/storage/receipt/'.$value->receipt_path; 
    }

    public function gettransction_id()
    {
        return $this->hasOne('App\Transactionhistoriesagent','request_id','id')->select('transaction_id')->first();
    }

    public function getreason()
    {
        return $this->hasOne('App\Agentdepositcancelrequest','request_id','id')->select('reason')->first();
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
}
