<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'qty', 'order_id', 'price', 'cost_price', 'product_info', 'status', 'customer_qty_price', 'agent_price', 'agent_qty_price', 'cost_price','discount', 'variation_id', 'seller_id','updated_qty','shocking_sale'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function orderAddress()
    {
        return $this->hasOne('App\OrderAddress', 'order_id', 'id');
    }

    public function orderImage()
    {
        return $this->hasMany('App\OrderImage', 'order_id', 'id');
    }

    public function orderProduct()
    {
        return $this->hasMany('App\OrderProduct', 'order_id', 'id');
    }

    public function product()
    {
        return $this->hasMany('App\Product', 'id', 'product_id');
    }

    public function order()
    {
        return $this->hasOne('App\Order', 'id', 'order_id');
    }

    public function productdetail()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function attributevariationprice()
    {
        return $this->belongsTo('App\AttributeVariationPrice', 'variation_id');
    }


    public function variation()
    {
        return $this->belongsTo('App\AttributeVariationPrice','variation_id');
    }

    public function reviewrating()
    {
        return $this->hasOne('App\ReviewRating');
    }
}
