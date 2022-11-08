<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserVoucher;
use Carbon\Carbon;

class PromotionContentVoucher extends Model
{
    protected $fillable = ['promotion_id','voucher_id'];
    protected $appends = ['redeemed','claimed','expired'];


    public function voucher()
    {
        return $this->belongsTo('App\Voucher','voucher_id');
    }

    public function getExpiredAttribute(){
        $date_diff = Carbon::parse($this->created_at);
        $days = $date_diff->diffInDays(Carbon::now());

        return ($days > 30) ? true : false;

    }

    public function getRedeemedAttribute()
    {
        if(!auth()->check()){
            return false;
        }
        $user_id = auth()->user()->id;
        return UserVoucher::where('voucher_id',$this->voucher_id)->where('promotion_id',$this->promotion_id)->where('user_id', $user_id)->where('status',1)->count();
    }

    public function getClaimedAttribute()
    {
        if(!auth()->check()){
            return 0;
        }
        $user_id = auth()->user()->id;
        return UserVoucher::where('voucher_id',$this->voucher_id)->where('promotion_id',$this->promotion_id)->where('user_id', $user_id)->where('status',0)->count();
    }
}
