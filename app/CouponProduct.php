<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponProduct extends Model
{
    protected $table = 'coupon_products';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','coupon_id', 'product_id','created_at','updated_at'
    ];

    public function coupon()
    {
         return $this->hasOne('App\Coupon', 'id', 'coupon_id');
    }

    public function product()
    {
         return $this->hasOne('App\Product', 'id', 'product_id');
    }

   
}
