<?php

namespace App;

use App\AttributeVariationPrice;
use App\Language;
use App\Productlanguage;
use App\ProductPrice;
use App\Role;
use App\Wishlist;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\OrderProduct;

class Product extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'code', 'sku', 'description', 'qty', 'status', 'is_deleted', 'video', 'seller_id', 'free_shipping', 'is_variation', 'seller_id', 'deduct_agent_wallet','slug'
    ];

    protected $hidden = [
        'pivot','created_at','updated_at', 'plat_leader_price', 'gold_leader_price', 'silver_leader_price', 'diamond_leader_price', 'executive_leader_price'
    ];
    protected $appends = ['sold','favorite','wishlist','shocking_sell','rating'];

    public function getShockingSellAttribute(){
        // if(!$this->is_variation){
            if($this->shockingsale && $this->shockingsale->goal > $this->shockingsale->percent_archived['sold']){
                return true;
            }
            return false;
        // }

        return false;
    }

    public function getSellPriceAttribute($value){
        if(!$this->is_variation){
            if($this->shockingsale  && $this->shockingsale->goal > $this->shockingsale->percent_archived['sold']){
                $discount = 100 - $this->shockingsale->discount;
                $price = $value * ($discount / 100);
                return $price;
            }
            return $value;
        }

        return $value;
    }

    public function categories()
    {
        return $this->hasMany('App\ProductCategory', 'product_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function images()
    {
        return $this->hasMany('App\ProductImage', 'product_id', 'id');
    }

    public function image()
    {
        return (object)$this->hasOne('App\ProductImage', 'product_id', 'id');
        // if (!empty($image)) {
        //     return url('public') . '/images/product/' . $image->image;
        // } else {
        //     return '';
        // }
    }

    public function getTagAttribute($value)
    {

        if (is_null($value)) {
            return '';
        }
        return $value;
    }

    public function productPrice()
    {
        return $this->hasMany('App\ProductPrice', 'product_id', 'id');
    }

    public function getStock()
    {
        $user = Auth::user();
        if ($user->role_id == 1) {
            return $this->qty;
        } else {
            $stock = $this->hasOne('App\ProductStock', 'product_id', 'id')->where("user_id", $user->id)->get();
            if (count($stock) == 1) {
                return $stock[0]->qty;
            } else {
                return 0;
            }
        }
    }

/*Created By Arvind*/
    /* public function getActualProductPrice($product, $newSales = 0,$user_id = 0){
    if($user_id != 0){
    $user = User::find($user_id);
    }else{
    $user = Auth::user();
    }
    }*/
    public function get_product_pv_point($user, $product_id, $variation_id = null)
    {
        if(!$user){
            return 0;
        }
        $price = 0;
        if (!$variation_id) {

            $product = $this->find($product_id);
            //$this->info( $product_id);die;
        } else {
            $product = AttributeVariationPrice::where('id', $variation_id)->first();
        }
        if ($user->role_id == 2) {
            $price = $product->diamond_pv_point;
        }
        if ($user->role_id == 3) {
            $price = $product->platinum_pv_point;
        }
        if ($user->role_id == 4) {
            $price = $product->golden_pv_point;
        }
        if ($user->role_id == 5) {
            $price = $product->silver_pv_point;
        }
        if ($user->role_id == 6) {
            $price = $product->executive_pv_point;
        }
        if ($user->role_id == 15) {
            $price = $product->staff_pv_point;
        }

        return $price;
    }

    public function get_product_price($user, $product_id, $variation_id = null)
    {
        $price = 0;
        if (!$variation_id) {

            $product = $this->find($product_id);
            //$this->info( $product_id);die;
        } else {
            $product = AttributeVariationPrice::where('id', $variation_id)->first();
        }
        if ($user->role_id == 2) {
            $price = $product->diamond_leader_price;
        }
        if ($user->role_id == 3) {
            $price = $product->plat_leader_price;
        }
        if ($user->role_id == 4) {
            $price = $product->gold_leader_price;
        }
        if ($user->role_id == 5) {
            $price = $product->silver_leader_price;
        }
        if ($user->role_id == 6) {
            $price = $product->executive_leader_price;
        }
        if ($user->role_id == 7) {
            $price = $product->customer_price;
        }

        if ($user->role_id == 15) {
            $price = $product->staff_price;
        }

        return $price;
    }

    public function get_single_product_customer_price($product_id)
    {
        $product = $this->find($product_id);
        $price = $product->customer_price;
        return $price;
    }
    /*get customer priceper qty*/

    public function getcustomerproductprice($user, $product_id, $qty, $variation_id = null)
    {
        $price = 0;
        $product = $this->find($product_id);
        if ($product_id != '' && $qty != '' && $qty != 0) {
            if (!$variation_id) {

                // if ($qty == 1) {
                $price = $product->sell_price;
                // } else {
                //     $daynamic_customer_price = Customerpricetier::where('product_id', $product->id)->where('qty', '<=', $qty)->orderBy('qty', "DESC")->first();
                //     if (count($daynamic_customer_price) == 0) {
                //         $price = $product->customer_price;
                //     } else {
                //         $price = $daynamic_customer_price->price;
                //     }
                // }
            } else {
                $result = AttributeVariationPrice::where('id', $variation_id)->first();
                // dd($result);
                $price = $result->sell_price;
            }
        }
        return $price;
    }

    public function getstaffproductprice($user, $product_id, $qty)
    {
        $price = 0;
        $product = $this->find($product_id);
        if ($product_id != '' && $qty != '' && $qty != 0) {
            // if ($qty == 1)
            // {
            $price = $product->staff_price;
            // }
        }
        return $price;
    }

/*Not used function*/
    public function getProductPrice($product, $newSales = 0, $user_id = 0)
    {
        if ($user_id != 0) {
            $user = User::find($user_id);
        } else {
            $user = Auth::user();
        }
        if ($user->role_id == 1) {
            return $product->sell_price;
        } else if ($user->role_id == 2) {
            return $product->tm_price;
        } else if ($user->role_id == 3) {
            return $product->id_price;
        } else if ($user->role_id == 4) {
            return $product->gm_price;
        } else if ($user->role_id == 5) {
            return $product->sm_price;
        } else if ($user->role_id == 6) {
            $user = User::find($user->id);
            $salesLevel = Rank::orderBy('sales', 'ASC')->get();
            $newSales += $user->monthly_sales;
            $salelevel = $user->rank_id == 0 ? 4 : $user->rank_id;
            for ($i = 0; $i < count($salesLevel); $i++) {
                if ($newSales >= $salesLevel[$i]->sales &&
                    $salelevel <= $salesLevel[$i]->id) {
                    $salelevel = $salesLevel[$i]->id;
                }
            }
            if ($salelevel == 1) {
                return $product->plat_leader_price;
            } else if ($salelevel == 2) {
                return $product->gold_leader_price;
            } else if ($salelevel == 3) {
                return $product->silver_leader_price;
            } else {
                return $product->upcoming_leader_price;
            }
        } else if ($user->role_id == 7) {
            return $product->sell_price;
        } else if ($user->role_id == 15) {
            return $product->staff_price;
        } else {
            return $product->sell_price;
        }
    }

    public function inwish($user_id)
    {
        $t = Wishlist::where('product_id', $this->id)->where('user_id', $user_id)->first();
        // print_r($t);die();
        // return $t;
        if (!empty($t)) {
            return true;
        } else {
            return false;
        }
    }

    public function price_detailold($id)
    {
        $product = $this->find($id);
        $myArray = array();
        $role = Role::get();
        foreach ($role as $value) {
            if ($value->id == 2) {
                $myArray[$value->id] = array('name' => $value->name, 'price' => $product->diamond_leader_price);
            }
            if ($value->id == 3) {
                $myArray[$value->id] = array('name' => $value->name, 'price' => $product->plat_leader_price);
            }
            if ($value->id == 4) {
                $myArray[$value->id] = array('name' => $value->name, 'price' => $product->gold_leader_price);
            }
            if ($value->id == 5) {
                $myArray[$value->id] = array('name' => $value->name, 'price' => $product->silver_leader_price);
            }
            if ($value->id == 6) {
                $myArray[$value->id] = array('name' => $value->name, 'price' => $product->executive_leader_price);
            }
            if ($value->id == 7) {
                $myArray[$value->id] = array('name' => $value->name, 'price' => $product->customer_price);

            }
        }
        // $myArray[16] = array('name'=>'Sale Price', 'price'=>$product->sell_price);

        return $myArray;
    }

    public function price_detail($id)
    {
        $product = $this->find($id);
        $myArray = array();
        $role = Role::get();
        foreach ($role as $value) {
            if ($value->id == 2) {
                $myArray[$value->id] = array('name' => $value->name, 'price' => $product->diamond_leader_price);
            }
            if ($value->id == 3) {
                $myArray[$value->id] = array('name' => $value->name, 'price' => $product->plat_leader_price);
            }
            if ($value->id == 4) {
                $myArray[$value->id] = array('name' => $value->name, 'price' => $product->gold_leader_price);
            }
            if ($value->id == 5) {
                $myArray[$value->id] = array('name' => $value->name, 'price' => $product->silver_leader_price);
            }
            if ($value->id == 6) {
                $myArray[$value->id] = array('name' => $value->name, 'price' => $product->executive_leader_price);
            }
            if ($value->id == 7) {
                $myArray[$value->id] = array('name' => $value->name, 'price' => $product->customer_price);

            }
            if ($value->id == 15) {
                $myArray[$value->id] = array('name' => $value->name, 'price' => $product->staff_price);
            }

        }
        $myArray[16] = array('name' => 'Sale Price', 'price' => $product->sell_price);

        return $myArray;
    }

    public function getmonthqty()
    {
        $test = $this->hasMany('App\OrderProduct', 'product_id', 'id')->selectRaw('order_products.product_id, SUM(order_products.qty) as total')->groupBy('order_products.product_id');
        return $test;
    }

    public function printproductname($local, $product_id)
    {
        $language_id = Language::where('code', $local)->first();
        $product = Product::where('id', $product_id)->first();
        if ($language_id->id == 1) {
            return $product->name;
        } else {
            $productlanguage = Productlanguage::where('product_id', $product_id)->where('language_id', $language_id->id)->first();
            if (isset($productlanguage->product_name)) {
                return $productlanguage->product_name;
            } else {
                return $product->name;
            }
        }
    }

    public function printproductdescription($local, $product_id)
    {
        $language_id = Language::where('code', $local)->first();
        $product = Product::where('id', $product_id)->first();
        if ($language_id->id == 1) {
            return $product->description;
        } else {
            $productlanguage = Productlanguage::where('product_id', $product_id)->where('language_id', $language_id->id)->first();
            if (isset($productlanguage->product_description)) {
                return $productlanguage->product_description;
            } else {
                return $product->description;
            }
        }
    }
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id')->where('status', 'active')->where('is_deleted','0');
    }

    /**
     * Get the seller that owns the product.
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function attributevariation()
    {
        return $this->hasMany(AttributeVariation::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function attributevariationprice()
    {
        return $this->hasMany(AttributeVariationPrice::class);
    }

    public function variation()
    {
        return $this->hasOne(AttributeVariationPrice::class);
    }

    public function shockingsale()
    {
        return $this->hasOne(ShockingsaleProduct::class,'product_id')->where('start_date','<=',date('Y-m-d H:i:s'))->where('end_date','>=',date('Y-m-d H:i:s'))->where('status','active');
    }

    public function getSoldAttribute()
    {
        return $this->hasMany(OrderProduct::class)->whereHas('order', function ($query) {
            $query->whereIn('status', ['confirmed', 'shipped', 'delivered']);
        })->sum('qty');
    }

     public function soldBetweenDate($product_id,$start_date,$end_date)
    {
        return OrderProduct::where('product_id',$product_id)->whereHas('order', function ($query) {
            $query->whereIn('status', ['confirmed', 'shipped', 'delivered']);
        })->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('qty');
    }

    public function getFavoriteAttribute()
    {
        return $this->hasMany(Wishlist::class)->count();
    }

    public function getWishlistAttribute()
    {
        if(!auth()->check()){
            return 0;
        }
        $user_id = auth()->user()->id;
        return Wishlist::where('product_id',$this->id)->where('user_id',$user_id)->count();
    }

    public function reviews()
    {
        return $this->hasMany('App\ReviewRating');
    }

    public function getRatingAttribute(){
        return ['avg_rate' => ($this->reviews()->count() > 0) ? round($this->reviews()->avg('rate'),2) : 0,'total' => $this->reviews()->count()];
    }

    public function avgReviewRating()
    {
        return $this->reviews()->avg('rate');
    }

    public function countReviewRating()
    {
        return $this->reviews()->count();
    }

    public function getRateCount($product_id, $rate)
    {
        $count = 0;
        if (is_int($rate)) {
            $count = ReviewRating::where('product_id', $product_id)
                ->where('rate', $rate)
                ->count();
        } elseif ($rate == 'comment') {
            $count = ReviewRating::where('product_id', $product_id)
                ->whereNotNull('reply')
                ->where('reply', '!=', '')
                ->count();
        } elseif ($rate == 'media') {
            $count = ReviewRating::where('product_id', $product_id)
                ->whereHas('reviewRatingImages')
                ->count();
        }
        return $count;
    }
    // public function getVideoAttribute($value)
    // {
    //     if ($this->type == "videoupload") {
    //         if (Storage::disk('s3')->exists('images/productvideo/' . $value) && $value) {
    //             return Storage::disk('s3')->url('images/productvideo/' . $value);
    //         };
    //         return '';
    //     } else {
    //         return $value;
    //     }
    // }

    // public function getPhotosZipFileAttribute($value)
    // {
    //     if (Storage::disk('s3')->exists('images/product_photos_zip/' . $value) && $value) {
    //         return Storage::disk('s3')->url('images/product_photos_zip/' . $value);
    //     };
    //     return '';
    // }

    // public function getVideoThumbAttribute($value)
    // {
    //     if (Storage::disk('s3')->exists('images/productvideothumbthumb/' . $value) && $value) {
    //         return Storage::disk('s3')->url('images/productvideothumbthumb/' . $value);
    //     };
    //     return '';
    // }
    public function allCategories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }
}
