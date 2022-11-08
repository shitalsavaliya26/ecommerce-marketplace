<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\AttributeVariationPrice;

class AttributeVariation extends Model
{
    // use SoftDeletes;

    protected $hidden = ['created_at','updated_at','staff_price', 'staff_commission_price','executive_leader_price',
                         'silver_leader_price', 'gold_leader_price', 'plat_leader_price','diamond_leader_price'];

    // protected $appends = ['variation_prices'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
    public function getVariationPricesAttribute($value)
    {
        $prices = AttributeVariationPrice::where('product_id',$this->product_id)->get();
        $result = [];
        foreach($prices as $price){
            if(in_array($this->id, $price->variation_value)){
                $result[] = $price;
            }
        }
        return $result;
    }

}
