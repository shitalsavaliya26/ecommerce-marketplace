<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponReport extends Model
{
    protected $table = 'coupon_reports';
    //
    protected $dates = [ 'redeemed_date' ];

    protected $fillable = [
        'id','coupon_id', 'user_id','product_id','order_id','redeemed_date','created_at','updated_at'
    ];

    public function coupon(){
        return $this->belongsTo('App\Coupon','coupon_id','id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function product(){
        return $this->belongsTo('App\Product','product_id','id');
    }

    public function order(){
        return $this->belongsTo('App\Order','order_id','id');
    }
}
