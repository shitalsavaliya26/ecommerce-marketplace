<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingCompanySeller extends Model
{
    protected $fillable = ['shipping_company_id','state_id','weight_price','max_volume','seller_id','max_weight'];
    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function shippingcompany()
    {
        return $this->belongsTo(ShippingCompany::class,'shipping_company_id');
    }

    public function seller()
    {
        return $this->belongsTo('App\Seller', 'seller_id', 'id');
    }

    public function additional_rule()
    {
        return $this->hasOne('App\ShippingSellerAdditionalRule','shipping_company_seller_id');
    }
}
