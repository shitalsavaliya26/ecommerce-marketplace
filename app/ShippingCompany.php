<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingCompany extends Model
{
    public function shippingcompanyseller()
    {
        return $this->hasMany('App\ShippingCompanySeller', 'shipping_company_id', 'id');
    }
    public function shippingcompanypostcode()
    {
        return $this->hasMany('App\Shippingcompanypostcode', 'shipping_company_id', 'id');
    }
    public function shippingcompanypricetier()
    {
        return $this->hasMany('App\ShippingCompanyPricetier', 'shipping_company_id', 'id');
    }
    protected static function boot()
    {
        parent::boot();
    }
    public function shippingcompanystate()
    {
        return $this->hasMany('App\ShippingCompanyState', 'shipping_company_id');
    }

    public function getShippingPrice($weight,$state,$volume,$item){

        $max_weight = $item->shippingcompanyseller[0]->max_weight;
        $weight_price = $item->shippingcompanyseller[0]->weight_price;
        if($state->direction == 'east'){
            $volumeweight = 0;
            if($volume > 0){
                $volumeweight = $volume / config('services.CART_WEIGHT_DEVISION');
            }
            if($volumeweight > $weight){
                $weight = $volumeweight;
            }
        }
        if($weight == 0){
           return 0;
        }
        $weight = ($weight > 0) ? $weight : 1;

        // echo $weight;die();
        $additional_weight = $weight - $max_weight;

        if($weight > 1){
            $additional_weight_price = $weight - 1;

            $totalprice = $weight_price + ($additional_weight_price * $item->shippingcompanyseller[0]->additional_rule->additional_weight_price);
        }else{
            $totalprice = $weight_price * $weight;
        }
        
        return $totalprice;

    }
}
