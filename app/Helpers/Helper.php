<?php
namespace App\Helpers;

use App\ShippingCompany;
use App\Seller;
use App\Product;
use App\State;
use App\Cart;
use App\AttributeVariationPrice;
use App\OrderProduct;
use App\OrderVoucher;
use App\Order;
use Auth;
use App\ShippingCompanySeller;
use App\CoinManagement;
use App\Voucher;
use App\SellerFollower;
use App\User;

class Helper
{
    public static function encrypt($id){
        $encrypted_string=openssl_encrypt($id,config('services.encryption.type'),config('services.encryption.secret'));
        return base64_encode($encrypted_string);
    }
    public static function decrypt($id){
        $string=openssl_decrypt(base64_decode($id),config('services.encryption.type'),config('services.encryption.secret'));
        return $string;
    }
    public static function getPaymentMethods($product_cod = 1){
        if (auth()->user()->role_id < 7) {
            if ($product_cod) {
                $paymentMethods[] = [
                    'shipping_id' => 1,
                    'name' => 'COD',
                ];
            }
            $paymentMethods[] = [
                'shipping_id' => 2,
                'name' => 'Bank Transfer',
            ];
            $paymentMethods[] = [
                'shipping_id' => 3,
                'name' => 'Wallet',
            ];
        } elseif (auth()->user()->role_id == 15) {
            if ($product_cod) {
                $paymentMethods[] = [
                    'shipping_id' => 1,
                    'name' => 'COD',
                ];
            }
            $paymentMethods[] = [
                'shipping_id' => 2,
                'name' => 'Bank Transfer',
            ];
        } else {
            $paymentMethods[] = [
                'shipping_id' => 2,
                'name' => 'Bank Transfer',
            ];
        }
        return $paymentMethods;
    }

    /**
     * Display a listing of the request.
     *
     * @return \Illuminate\Http\Request
     */
    public static function customerPrice($product_id){
        $price = 0;
        $product = Product::find($product_id);
        if ($product_id != '') {
            if ($product->is_variation != 1) {
                $price = $product->customer_price;
            } else {
                $result = AttributeVariationPrice::where('product_id', $product->id)->first();
                if($result){
                    $price = $result->id;
                }else{
                    $price = $product->customer_price;
                }
            }
        }
        return $price;
    }

    public static function getShippingCharge($address, $weight, $user,$shipping_ids,$shippingcompany)
    {
        $response   = [];
        $i= 0; 
        foreach($shipping_ids as $key => $shipping){
            $pricearr = [];
            // $shipping = json_decode($shipping);
            $seller = Seller::find($shipping[0]->seller_id);

            $shippingcompany_id = $shippingcompany;
            // $company['seller_name'] = $seller->name;
            $weight = 0;
            $volume = 0;
            $actualweight = 0;
            $actualvolume = 0;
            $weightagent = 0;
            $volumeagent = 0;
            $weightstaffagent = 0;
            $volumestaffagent = 0;

            $all_methods_have_seller = 1;  
            $state = $address->state;   
            $state = State::where('name',$state)->first();

            $item1 = $item = Cart::wherehas('productdetails', function ($query) {
                            $query->where('is_deleted', '0')
                            ->where('status', "active");
                        })->with('variation')
                        ->where('user_id', $user->id)
                        ->where('seller_id',$seller->id)
                        ->get()
                        ->map(function($item){
                            $item->variation_value = $item->variation;
                            unset($item->variation);
                            return $item;
                        });
            foreach ($item as $cart_item) {
                $product = Product::select('id', 'name', 'weight','height','width','length','free_shipping','deduct_agent_wallet')->where('id', $cart_item->product_id)->first();
                if($product->free_shipping == '0' || $product->free_shipping == null){
                     if($cart_item->variation_id && $cart_item->variation_id != 0){
                        $product_weight = $cart_item->variation_value->weight * $cart_item->qty;
                        $weight +=  $product_weight;
                        $volume += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item->qty;
                    }else{
                        $product_weight = $product->weight * $cart_item->qty;
                        $weight +=  $product_weight;
                        $volume += ($product->height * $product->width * $product->length) * $cart_item->qty;
                    }
                }else{
                    if($cart_item->variation_id && $cart_item->variation_id != 0){
                        $product_weight = $cart_item->variation_value->weight * $cart_item->qty;
                        $weightstaffagent +=  $product_weight;
                        $volumestaffagent += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item->qty;
                    }else{
                        $product_weight = $product->weight * $cart_item->qty;
                        $weightstaffagent +=  $product_weight;
                        $volumestaffagent += ($product->height * $product->width * $product->length) * $cart_item->qty;
                    }
                }

                if($product->free_shipping == '1' && $product->deduct_agent_wallet == '1'){
                    if($cart_item->variation_id && $cart_item->variation_id != 0){
                        $product_weightagent = $cart_item->variation_value->weight * $cart_item->qty;
                        $weightagent +=  $product_weightagent;
                        $volumeagent += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item->qty;
                    }else{
                        $product_weightagent = $product->weight * $cart_item->qty;
                        $weightagent +=  $product_weightagent;
                        $volumeagent += ($product->height * $product->width * $product->length) * $cart_item->qty;
                    }
                }
                if($cart_item->variation_id && $cart_item->variation_id != 0){
                    $actualweight += $cart_item->variation_value->weight * $cart_item['qty'];
                    $actualvolume += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item['qty'];
                }else{

                    $actualweight += $product->weight * $cart_item['qty'];
                    $actualvolume += ($product->height * $product->width * $product->length) * $cart_item['qty'];
                }
            }

            $response[] = ShippingCompany::whereHas('shippingcompanyseller',function($query) use ($seller,$state){
                                                        $query->where('seller_id',$seller->id)->where('state_id',$state->id);
                                                    })
                                                    // ->whereHas('shippingcompanystate',function($query) use ($address){
                                                    //     $query->where('state',$address->state);
                                                    // })
                                                    ->where('id',$shippingcompany_id[$i])
                                                    ->select('id')
                                                    ->get()
                                                    ->map(function($item) use ($weight,$state,$volume,&$pricearr,$shipping,$item1,$seller,$actualvolume,$actualweight,$weightagent,$volumeagent,$weightstaffagent,$volumestaffagent){
                                                        $no_track = 0;
                                                        unset($item->shippingcompanyseller);
                                                        $item->shippingcompanyseller = ShippingCompanySeller::where('seller_id',$seller->id)->where('state_id',$state->id)->where('shipping_company_id',$item->id)->get();
                                                        if($volume > $item->max_volume && $item->max_volume > 0){
                                                            $number = ceil($volume / $item->max_volume);
                                                            $tracking_number = $number;
                                                        }else{
                                                            $tracking_number = 1;
                                                        }
                                                        if($weight > 0 && $item->max_weight > 0){
                                                            $no_track = ceil($weight/$item->max_weight);
                                                        }else{
                                                          $item->price = 0;
                                                        }
                                                        if($weight > $item->max_weight && $item->max_weight > 0){
                                                            $no_track = ceil($weight/$item->max_weight);
                                                        }
                                                        if($no_track >  $tracking_number){
                                                             $tracking_number = $no_track;
                                                        }
                                                        $pricearr[$shipping[0]->seller_id] = ['tracking_number' => $tracking_number,'price' => $item->getShippingPrice($weight,$state,$volume,$item), 'volume' => $volume, 'weight' => $weight,'items' => $item1,'seller_id' => $seller->id,'shipping_company' => $item->id,'actual_price' => $item->getShippingPrice($actualweight,$state,$actualvolume,$item),'agent_price' => ($weightagent > 0) ? $item->getShippingPrice($weightagent,$state,$volumeagent,$item) : 0,'staff_price' => ($weightstaffagent > 0) ? $item->getShippingPrice($weightstaffagent,$state,$volumestaffagent,$item) : 0];
                                                        unset($item->shippingcompanyseller);
                                                        return $pricearr;
                                                    });
                                                    $i++;
        }

        if(!$all_methods_have_seller){
            return false;
        }
        return $response;
        
    }

    /* get shipping companies for sheller and products */
    public static function getShippingCompanies($request,$address){
        // dd(session()->get('shippingmethod'));
        if(!$address){
            return trans('messages.notshippingrule');
        }
        $state = State::where('name',$address->state)->first();
        if(!$state){
            return trans('messages.notshippingrule');
        }
        $weight = 0;
        $volume = 0;
         $actualweight = 0;
            $actualvolume = 0;
            $weightagent = 0;
            $volumeagent = 0;
            $weightstaffagent = 0;
            $volumestaffagent = 0;
        foreach ($request['products'] as $product_detail) 
        {
            $product = Product::select('id', 'name', 'weight','height','width','length')->where('id',$product_detail->product_id)->first();
            if($product->free_shipping == '0' || $product->free_shipping == null){

                     if($product_detail->variation_id && $product_detail->variation_id != 0){
                        $product_weight = $product_detail->variation->weight * $product_detail->qty;
                        $weight +=  $product_weight;
                        $volume += ($product_detail->variation->height * $product_detail->variation->width * $product_detail->variation->length) * $product_detail->qty;
                    }else{
                        $product_weight = $product->weight * $product_detail->qty;
                        $weight +=  $product_weight;
                        $volume += ($product->height * $product->width * $product->length) * $product_detail->qty;
                    }
                }else{
                    if($product_detail->variation_id && $product_detail->variation_id != 0){
                        $product_weight = $product_detail->variation->weight * $product_detail->qty;
                        $weightstaffagent +=  $product_weight;
                        $volumestaffagent += ($product_detail->variation->height * $product_detail->variation->width * $product_detail->variation->length) * $product_detail->qty;
                    }else{
                        $product_weight = $product->weight * $product_detail->qty;
                        $weightstaffagent +=  $product_weight;
                        $volumestaffagent += ($product->height * $product->width * $product->length) * $product_detail->qty;
                    }
                }

                if($product->free_shipping == '1' && $product->deduct_agent_wallet == '1'){
                    if($product_detail->variation_id && $product_detail->variation_id != 0){
                        $product_weightagent = $product_detail->variation->weight * $product_detail->qty;
                        $weightagent +=  $product_weightagent;
                        $volumeagent += ($product_detail->variation->height * $product_detail->variation->width * $product_detail->variation->length) * $product_detail->qty;
                    }else{
                        $product_weightagent = $product->weight * $product_detail->qty;
                        $weightagent +=  $product_weightagent;
                        $volumeagent += ($product->height * $product->width * $product->length) * $product_detail->qty;
                    }
                }
                if($product_detail->variation_id && $product_detail->variation_id != 0){
                    $actualweight += $product_detail->variation->weight * $product_detail->qty;
                    $actualvolume += ($product_detail->variation->height * $product_detail->variation->width * $product_detail->variation->length) * $product_detail->qty;
                }else{

                    $actualweight += $product->weight * $product_detail->qty;
                    $actualvolume += ($product->height * $product->width * $product->length) * $product_detail->qty;
                }
        }
        // dd($weight);
        $seller = Seller::find($request['seller_id']);
        $result = [];
        $result['shipping_companies'] = ShippingCompany::whereHas('shippingcompanyseller',function($query) use ($seller,$state){
                                                                      $query->where('seller_id',$seller->id)->where('state_id',$state->id);
                                                                  })
                                                                ->with('shippingcompanyseller')
                                                                   ->select('id','name','slug')
                                                                   ->get()
                                                                   ->map(function($item) use ($weight,$state,$volume,$seller,&$result){

                                                                        $item->default = false;
                                                                        $shippingmethod =  session()->get('shippingmethod') ;
                                                                        if(isset($shippingmethod[$seller->id]) && $item->id == $shippingmethod[$seller->id]['shipping_company']){
                                                                            $item->default = true;
                                                                        }
                                                                        unset($item->shippingcompanyseller);
                                                                        $item->shippingcompanyseller = ShippingCompanySeller::where('seller_id',$seller->id)->where('state_id',$state->id)->where('shipping_company_id',$item->id)->get();
                                                                        
                                                                        if($weight > 0){
                                                                            $item->price = $item->getShippingPrice($weight,$state,$volume,$item);
                                                                        }else{
                                                                            $item->price = 0;
                                                                        }
                                                                        if($item->default){
                                                                            $result['shipping_company'] = $item;
                                                                        }
                                                                        unset($item->shippingcompanyseller);
                                                                        return $item;
                                                                    });


        return $result;
    }

    /* get shipping company */
    public static function getShippingChargeBySeller($item1,$address,$shippingcompany_id,$seller_id){
        // dd
       $seller = Seller::find($seller_id);
       $weight = 0;
       $volume = 0;
       $actualweight = 0;
       $actualvolume = 0;
       $weightagent = 0;
       $volumeagent = 0;
       $response   = [];      
       $all_methods_have_seller = 1;  
       $state = $address->state;   
       $state = State::where('name',$state)->first();


       foreach ($item1 as $kay => $cart_item) {
                $product = Product::select('id', 'name', 'weight','height','width','length','free_shipping','deduct_agent_wallet')->where('id', $cart_item->product_id)->first();
                if($product->free_shipping == '0'){
                    if($cart_item->variation_id && $cart_item->variation_id != 0){
                        $product_weight = $cart_item->variation_value->weight * $cart_item->qty;
                        $weight +=  $product_weight;
                        $volume += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item->qty;
                    }else{
                        $product_weight = $product->weight * $cart_item->qty;
                        $weight +=  $product_weight;
                        $volume += ($product->height * $product->width * $product->length) * $cart_item->qty;
                    }
                }

                if($product->free_shipping == '1' && $product->deduct_agent_wallet == '1'){
                    if($cart_item->variation_id && $cart_item->variation_id != 0){
                        $product_weightagent = $cart_item->variation_value->weight * $cart_item->qty;
                        $weightagent +=  $product_weightagent;
                        $volumeagent += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item->qty;
                    }else{
                        $product_weightagent = $product->weight * $cart_item->qty;
                        $weightagent +=  $product_weightagent;
                        $volumeagent += ($product->height * $product->width * $product->length) * $cart_item->qty;
                    }
                }
                if($cart_item->variation_id && $cart_item->variation_id != 0){
                    $actualweight += $cart_item->variation_value->weight * $cart_item['qty'];
                    $actualvolume += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item['qty'];
                }else{

                    $actualweight += $product->weight * $cart_item['qty'];
                    $actualvolume += ($product->height * $product->width * $product->length) * $cart_item['qty'];
                }
            }

            $shipping_companies = ShippingCompany::whereHas('shippingcompanyseller',function($query) use ($seller,$state){
                                                        $query->where('seller_id',$seller->id)->where('state_id',$state->id);
                                                    })
                                                    // ->whereHas('shippingcompanystate',function($query) use ($address){
                                                    //     $query->where('state',$address->state);
                                                    // })
                                                    ->where('id',$shippingcompany_id)
                                                    ->select('id')
                                                    ->get()
                                                    ->map(function($item) use ($weight,$state,$volume,&$pricearr,$product,$item1,$seller,$actualvolume,$actualweight,$weightagent,$volumeagent){
                                                        //$item->price = $item->getShippingPrice($weight,$state,$volume,$item);
                                                        $no_track = 0;
                                                        unset($item->shippingcompanyseller);
                                                                        
                                                        $item->shippingcompanyseller = ShippingCompanySeller::where('seller_id',$seller->id)->where('shipping_company_id',$item->id)->where('state_id',$state->id)->get();
                                                        if($volume > $item->max_volume && $item->max_volume > 0){
                                                            $number = ceil($volume / $item->max_volume);
                                                            $tracking_number = $number;
                                                        }else{
                                                            $tracking_number = 1;
                                                        }
                                                        if($weight > 0 && $item->max_weight > 0){
                                                            $no_track = ceil($weight/$item->max_weight);
                                                        }else{
                                                          $item->price = 0;
                                                        }
                                                        if($weight > $item->max_weight && $item->max_weight > 0){
                                                            $no_track = ceil($weight/$item->max_weight);
                                                        }
                                                        if($no_track >  $tracking_number){
                                                             $tracking_number = $no_track;
                                                        }
                                                        // $item->tracking_number = $tracking_number;
                                                        // $item->weight = $weight;
                                                        $pricearr[$product->seller_id] = ['tracking_number' => $tracking_number,'price' => $item->getShippingPrice($weight,$state,$volume,$item), 'volume' => $volume, 'weight' => $weight,'items' => $item1,'seller_id' => $seller->id,'shipping_company' => $item->id,'actual_price' => $item->getShippingPrice($actualweight,$state,$actualvolume,$item),'agent_price' => ($weightagent > 0) ? $item->getShippingPrice($weightagent,$state,$volumeagent,$item) : 0];
                                                        // $pricearr['items'] = $item1;
                                                        // $pricearr['seller_id'] = $seller->id;
                                                        unset($item->shippingcompanyseller);
                                                        return $pricearr;
                                                    });
        return $shipping_companies;
    }
    
    public static function getVoucherData($couponId, $cartValue, $cartProductIds){
        if (Auth::check()) {
            $user = Auth::user();
           
            $coupon = Voucher::where('id', $couponId)
                ->with(['products' => function($q) use ($cartProductIds) {
                    $q->whereIn('product_id', $cartProductIds);
                }])->first();

            $priceArray = [];
            $productIDs = [];
            if( $coupon && $coupon->products){
                foreach($coupon->products as $product){
                    if($product->product){
                        $productIDs[] = $product->product->id;
                        $priceArray[] = ($product->product->is_variation == '1' && $product->product->variation) ? $product->product->variation->sell_price : $product->product->sell_price;
                    }
                }
            }

            $price = (count($priceArray) > 0) ? max($priceArray) : 0;
            $maxPriceProductIdKey = (count($priceArray) > 0) ? array_search(max($priceArray), $priceArray) : '';

            $pId = ($maxPriceProductIdKey !== '' && isset($productIDs[$maxPriceProductIdKey])) ? $productIDs[$maxPriceProductIdKey] : '';
            $pName = '';
            $productID = '';
            if($pId != ''){
                $product = Product::find($pId);
                $pName = ($product) ? $product->name : '';
                $productID = ($product) ? $product->id : '';
            }
            $discount = 0;
            $cashback = 0;
            $discountType = '';
            if($coupon){
                if($coupon->discount_type == 'by_percentage'){
                    $discount = ($coupon->discount_price * $price)/100;
                }else{
                    $discount = $coupon->discount_price;
                }
                if($coupon->max_discount_price_type == 'limit'){
                    $discount = $discount < $coupon->max_discount_price ? $discount: $coupon->max_discount_price;
                }

                if($coupon->reward_type == 'cashback'){
                    $cashback = $discount;
                    $discount = 0;
                }
                $discountType = $coupon->discount_type;
            }
            if($discount > $price ){
                $discount = $price;
            }
            if($cashback > $price ){
                $cashback = $price;
            }
            return ['discount' => $discount, 'cashback' => $cashback, 'product' => $pName, 'productID' => $productID, 'discountType' => $discountType];
        }
    }

    public static function getSellerVoucherDiscount($couponId , $subTotal){
        if (Auth::check()) {
            $user = Auth::user();
            $discount = 0;
            $cashback = 0;
            $subTotal = floatval($subTotal);
            $coupon = Voucher::where('id', (int) $couponId)->where('min_basket_price', '<=', $subTotal)->first();

            if($coupon){
                if($coupon->discount_type == 'by_percentage'){
                    $discount = ($coupon->discount_price * $subTotal)/100;
                }else{
                    $discount = $coupon->discount_price;
                }
                if($coupon->max_discount_price_type == 'limit'){
                    $discount = $discount < $coupon->max_discount_price ? $discount: $coupon->max_discount_price;
                }

                if($coupon->reward_type == 'cashback'){
                    $cashback = $discount;
                    $discount = 0;
                }
            }

            if($discount > $subTotal ){
                $discount = $subTotal;
            }
            if($cashback > $subTotal ){
                $cashback = $subTotal;
            }
            return ['discount' => round($discount, 2), 'cashback' => $cashback];
        }
    }

    /* generate slug */
    public static function slugify($text, string $divider = '-',$no = 0)
    {
      $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
      $text = preg_replace('~[^-\w]+~', '', $text);
      $text = trim($text, $divider);
      $text = preg_replace('~-+~', $divider, $text);
      $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        if($no > 0){
            $text .= uniqid();
        }
        return $text;
    }
    public static function getVoucherName($couponId){
        if (Auth::check()) {
            $user = Auth::user();
            $coupon = Voucher::where('id', (int) $couponId)->first();
            if($coupon){
                return $coupon->code;
            }
            else{
                return "";
            }
        }
    }

    public static function getVoucherType($couponId){
        if (Auth::check()) {
            $user = Auth::user();
            $coupon = Voucher::where('id', (int) $couponId)->first();
            if($coupon){
                return $coupon->type;
            }
            else{
                return "";
            }
        }
    }

    public static function dateWiseOrderTotal($orderIds){
        if (Auth::check()) {
            $sellerId = Auth::user()->seller->id;
            $total = 0;
            $coinManagement = CoinManagement::first();
            $admin_earn = 100 - (($coinManagement) ? $coinManagement->admin_earn : 3);
            if($orderIds && $orderIds > 0){
                foreach($orderIds as $orderId){
                    $orderProducts = OrderProduct::where('order_id', $orderId)->where('seller_id', $sellerId)->get()->toArray();
                    $orderProductPrice = array_column($orderProducts, 'price');
                    $orderProductQty = array_column($orderProducts, 'qty');
                    $combineArray = array_map(null, $orderProductPrice, $orderProductQty);

                    $totalOrderPrice = [];
                    foreach($combineArray as $multiple){
                        $totalOrderPrice[] = ((($multiple[0] * $multiple[1])* $admin_earn)/100);
                    }
                    $sumOfProductPrice = array_sum($totalOrderPrice);
                    $orderVoucherDiscount = OrderVoucher::where('reference_id', $sellerId)->where('order_id', $orderId)->first();
                    if($orderVoucherDiscount){
                        $sumOfProductPrice = $sumOfProductPrice - $orderVoucherDiscount->discount;
                    }
                    $total += $sumOfProductPrice;
                }
            }
            $total = round($total,2);

            return $total;
        }
    }

    public static function getOrderByIds($orderIds){
        if (Auth::check()) {
            $sellerId = Auth::user()->seller->id;

            $orders = [];
            if($orderIds && $orderIds > 0){
                $orders = Order::whereIn('id', $orderIds)->get();
            }
            return $orders;
        }
    }
    public static function isFollowing($sellerId){
        if (Auth::check()) {
            $checkExist = SellerFollower::where('seller_id', $sellerId)->where('customer_id', Auth::user()->id)->first();
            if($checkExist){
                return true;
            }
            return false;
        }
    }
    public static function getSellerImage($orderId){
       $order = Order::with('orderProduct')->where('order_id', $orderId)->first();
        if($order){
            $sellerId = '';
            if($order && $order->orderProduct && count($order->orderProduct) > 0){
                $sellerId = ($order->orderProduct[0]->seller_id);
                if($sellerId && $sellerId > 0){
                    $seller = Seller::find($sellerId);
                    if($seller){
                        $sellerImage = $seller->image;
                        if($sellerImage != '' && $sellerImage != null){
                            return $sellerImage;
                        }
                    }
                }
            }
        }
        return asset('assets/images/product-placeholder.png');
    }

    public static function get_actual_string($string){
        $array = explode('[product ', $string);
        for ($i=0; $i < count($array) - 1; $i++) { 
            $product = self::get_string_between($string, '[product ', ']');
            $prd = Product::find((int)str_replace(' ', '',$product));
            $product_html = view('frontend.singleproduct')->with('product', $prd)->render();
            $search = "[product ".$product."]";
            $totaltime = substr_count($string, $search);
            if($totaltime > 1){
                $i = $i + ($totaltime - 1);
            }
            $string = str_replace($search, $product_html, $string);

        }
        return $string;
    }

    public static function get_string_between($string, $start, $end){

        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public static function genrateusernamefromemail($email)
    {
        $username = explode("@", $email);
        $username = $username[0];
        $count =  User::where('username', 'like', "%" . $username . "%")->count();
        if ($count == 0) {
            return $username;
        } else {
            return $username . $count;
        }
    }

    public static function refId($name)
    {
        $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
        $name = substr($name, 0, 3);
        return strtoupper($name . rand(100, 999));
    }
}
