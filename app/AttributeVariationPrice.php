<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\AttributeVariation;

class AttributeVariationPrice extends Model
{
    use SoftDeletes;

    protected $hidden = ['created_at','updated_at','deleted_at'];

    protected $casts = ['variation_value' => 'array'];

    public function orderproducts() {
        return $this->hasMany('App\OrderProduct');
    }
    protected $appends = ['variation','shocking_sell'];


    public function getVariationAttribute()
    {
        $variations = AttributeVariation::whereIn('id',$this->variation_value)->pluck('variation_value')->toArray();
        return $variations;
    }

    public function shockingsale()
    {
        return $this->hasOne(ShockingsaleProduct::class,'product_id','product_id')->where('start_date','<=',date('Y-m-d H:i:s'))->where('end_date','>=',date('Y-m-d H:i:s'))->where('status','active');
    }

    public function getShockingSellAttribute($value){
        if($this->shockingsale && $this->shockingsale->goal > $this->shockingsale->percent_archived['sold']){
         return true;
     }
        return false;
    }
    public function getSellPriceAttribute($value){
        if($this->shockingsale){
            $discount = 100 - $this->shockingsale->discount;
            $price = $value * ($discount / 100);
            return $price;
        }
        return $value;

    }
}
