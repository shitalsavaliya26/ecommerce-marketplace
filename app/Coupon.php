<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'code','description','total_qty','usage_per_user','discount','status','is_deleted','expiry_date','created_at','updated_at'
    ];

    protected $dates = [ 'expiry_date' ];

    protected $hidden = ['created_at','updated_at'];

    public function couponproduct()
    {
         return $this->hasMany('App\CouponProduct', 'coupon_id', 'id');
    }

    public function couponusage()
    {
         return $this->hasMany('App\CouponReport', 'coupon_id', 'id');
    }
}
