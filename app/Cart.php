<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Customerpricetier;
use App\AttributeVariationPrice;

class Cart extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'user_id','qty','variation_id','seller_id', 'bundle_deal_id'
    ];

    public function user()
    {
         return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function productimage()
    {
        return $this->belongsTo('App\ProductImage');
    }

    public function variation()
    {
        return $this->belongsTo('App\AttributeVariationPrice','variation_id');
    }

    public function productdetails()
    {
      return $this->hasOne('App\Product', 'id', 'product_id')->select(array('id', 'name', 'customer_price','gold_leader_price','silver_leader_price','diamond_leader_price','executive_leader_price','plat_leader_price','staff_price','sell_price','slug'));
    }

    public function getproductprice($user, $product_id,$qty = 1,$variation_id = null)
    {
        if ($user != '' && $product_id != '') 
        {
            if(!$variation_id){
                $product = Product::find($product_id);
            }else{
                $product = AttributeVariationPrice::where('id',$variation_id)->first();
            }
            if ($user->role_id == 2) 
            {
                 return $product->diamond_leader_price;
            }
            if ($user->role_id == 3) 
            {
               return $product->plat_leader_price;
            }
            if ($user->role_id == 4) 
            {
               return $product->gold_leader_price;
            }
            if ($user->role_id == 5) 
            {
               return $product->silver_leader_price;
            }
            if ($user->role_id == 6) 
            {
               return $product->executive_leader_price;
            }
             if ($user->role_id == 7) 
            {
                // if ($qty == 1) 
                // {
                    return $product->sell_price;
                // }
                // else
                // {
                //     $daynamic_customer_price = Customerpricetier::where('product_id',$product->id)->where('qty','<=',$qty)->orderBy('qty',"DESC")->first();
                //     if (count($daynamic_customer_price) == 0) 
                //     {
                //        return $product->customer_price;
                //     }
                //     else
                //     {
                //         return $daynamic_customer_price->price;
                //     }
                // }
            }
            if ($user->role_id == 15) 
            {
                return $product->staff_price;
            }


        }
    }

    public function bundleDeal()
    {
        return $this->belongsTo('App\BundleDeal');
    }

    // public function getpaymentmethod2($postalcode, $weight, $user, $type)
    // {
}


