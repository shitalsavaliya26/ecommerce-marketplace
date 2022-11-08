<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerWithdrawRequest extends Model
{
    protected $fillable = [
        'user_id', 'account_number','bank_id','name','amount','reason','withdraw_request_from','status',
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];

    public function user()
    {
        return $this->hasOne('App\Seller','id','user_id');
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
        if($request->status == 'pending'){
            return 'Pending';
        }elseif($request->status == 'accept'){
            return 'Accepted';
        }elseif($request->status == 'reject'){
            return 'Rejected';
        }else{
            return $request->status;
        }
    }

    public function getbankname()
    {
        return $this->hasOne('App\Bank','id','bank_id')->select('name')->first(); 
    }
}
