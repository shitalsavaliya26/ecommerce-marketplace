<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Cart;
use Auth, Validator;
use App\Product;
use App\BundleDeal;
use App\Seller;
use App\CoinManagement;
use App\OrderAddress;
use App\Order;
use App\OrderProduct;
use App\Coupon;
use App\CouponReport;
use App\AttributeVariationPrice;
use App\Transactionhistoriescustomer;
use App\Transactionhistoriesstaff;
use App\Transactionhistoriesagent;
use App\Agentreceiver;
use App\Staffreceiver;
use App\UserAddress;
use App\Helpers\PaymentHelper;
use App\User;
use App\VoucherProduct;
use App\OrderShipping;
use App\Helpers\NotificationHelper;
use App\Notifications\OrderCancelled;
use App\PushNotification;
use App\OrderVoucher;
use App\Voucher;
use Notification,Response;
use Session;
use Illuminate\Support\Facades\Storage;
use App\ReviewRating;
use App\UserVoucher;
use App\SellerFollower;
use App\State;

class OrderContoller extends Controller
{
    public function changecart(Request $request){
        Session::put('cart_request_data', $request->all());
        Session::save();
        $user = Auth::user();
        $user->address()->where('current_address',1)->update(['current_address' => 0]);
        $defaultaddress = ($user->defaultaddress) ? $user->defaultaddress : $user->address->first();
        $user->defaultaddress()->update(['current_address' => 1]);
        $slug = array_map(function ($item) {
            return Helper::decrypt($item);
        },$request->prd);

        Cart::wherehas('productdetails', function ($query) {
                        $query->where('is_deleted', '0')
                        ->where('status', "active");
                    })->with('variation')
                    ->where('user_id', $user->id)
                    ->whereNotIn('id',$slug)
                    ->update(['status'=>'inactive']);
        Cart::wherehas('productdetails', function ($query) {
                        $query->where('is_deleted', '0')
                        ->where('status', "active");
                    })->with('variation')
                    ->where('user_id', $user->id)
                    ->whereIn('id',$slug)
                    ->update(['status'=>'active']);

        $voucherId = ($request->has('voucher_id') && $request->voucher_id > 0 && $request->voucher_id != '' ) ? $request->voucher_id : 0;
        return redirect()->route('checkout', ['dataId' => Helper::encrypt($voucherId)]);
    }

    public function add_balance($value='')
    {
        $userwallet = Auth::user();
        $userwallet->wallet_amount = $userwallet->wallet_amount + 1000;
        $userwallet->save();
        return redirect()->route('home');
    }

    public function checkout(Request $request){
        $requestData = Session::get('cart_request_data') ? Session::get('cart_request_data')  : [] ;
        $user = Auth::user();
        $bundleAmount = 0;
        $bundleDiscount = 0;
        $cartData = Cart::select('id','bundle_deal_id','product_id', 'qty')->with('bundleDeal')->where('user_id', $user->id)->get();
        $cartProductIds = array_column($cartData->toArray(), 'product_id');
        $bundleId = $cartData->groupBy('bundle_deal_id')->toArray();
        $bundleId = key($bundleId);
        $bundleProductIds = [];
        $orderFor = isset($requestData['orderFor']) ? $requestData['orderFor'] : '';
        $agentRole = [2, 3, 4, 5, 6];

        if($bundleId && $bundleId > 0){
            $bundleDealProductData = BundleDeal::with('BundleDealProducts')->find($bundleId);
            if($bundleDealProductData && $bundleDealProductData->BundleDealProducts && count($bundleDealProductData->BundleDealProducts) > 0){
                $bundleProducts = $bundleDealProductData->BundleDealProducts;
                $bundleProductIds = $bundleProducts->pluck('product_id')->toArray();
                foreach($bundleProductIds as $bundleProductId){
                    $product = Product::where('id', $bundleProductId)->first();
                    $variationId = $product->is_variation == '1' ? $product->variation->id : null;
                    $bundleAmount = $bundleAmount + $product->getcustomerproductprice($user, $bundleProductId, 1, $variationId);  
                }
                $bundleDiscount = ($bundleAmount * $bundleDealProductData->discount)/100;
            }
        }
        if($bundleProductIds){
            $cartContainBundleProduct = !array_diff($bundleProductIds, $cartProductIds);
        }else{
            $cartContainBundleProduct = false;
        }

        $cartContainBundleProduct = !array_diff($bundleProductIds, $cartProductIds);

        $cart = Cart::wherehas('productdetails', function ($query) {
                            $query->where('is_deleted', '0')
                            ->where('status', "active");
                        })->with('variation')
                        ->where('user_id', $user->id)
                        ->where('status', "active")
                        ->get()
                        ->map(function($item){
                            $item->variation_value = $item->variation;
                            unset($item->variation);
                            return $item;
                        })->groupBy('seller_id');

        if (count($cart) != 0) {
            $amount = 0;
            $cartitem = [];
            $sellerIDs = [];
            foreach ($cart as $key => $item) {
                $sellerIDs[] = Helper::encrypt($key);
                $totalitems = 0;
                $seller = Seller::find($key);
                $sellertotal = 0;
                $result = [];
                $result['seller_id'] = ($seller) ? $seller->id : '';
                $result['seller_name'] = ($seller) ? $seller->name : '';
                $result['image'] = ($seller) ? $seller->image : '';
                foreach($item as $cart_item){
                    $product        = $cart_item->productdetails;
                    $cart_item->productdetails->image = $cart_item->productdetails->image();
                    $product_amount = $cart_item->getproductprice($user, $product->id, $cart_item->qty,$cart_item->variation_id);
                    $product_amount = $product_amount * $cart_item->qty;
                    $amount         += $product_amount;
                    $sellertotal    += $product_amount;
                    $local = 'en';
                    $cart_item->productdetails->name  = $product->printproductname($local, $product->id);

                    $cart_item->productdetails->customer_price  = $product->getcustomerproductprice($user, $product->id, $cart_item->qty,$cart_item->variation_id);
                    $customer_total     = $cart_item->productdetails->customer_price * $cart_item->qty;
                    $product            = Product::find($cart_item->product_id);
                    $cart_item->productdetails->cod = ($product->cod) ? 1 : 0;
                    $cart_item->cod     = ($product->cod) ? 1 : 0;
                    $result['products'][] = $cart_item;
                    $productIds[] = $product->id;
                    $productDataArray[$product->id]['product_id'] = $product->id;
                    $productDataArray[$product->id]['qty'] = $cart_item->qty;

                    $totalitems += $cart_item->qty;
                }
                $result['seller_total'] = $sellertotal;
                $result['totalitems'] = $totalitems;
               
                if(Auth::user()->role_id == '15'){
                    if($orderFor == 'customer'){
                        $defaultaddress = ($user->defaultStaffCustomerAddress != '' && $user->defaultStaffCustomerAddress != null) ? $user->defaultStaffCustomerAddress : $user->staffCustomerReceivers()->first();
                        $current_address = ($user->currentStaffCustomerAddress && $user->currentStaffCustomerAddress->count() > 0) ? $user->currentStaffCustomerAddress->first() : $defaultaddress;
                    }else{
                        $defaultaddress = ($user->defaultStaffAddress != '' && $user->defaultStaffAddress != null) ? $user->defaultStaffAddress : $user->staffReceivers()->first();
                        $current_address = ($user->currentStaffAddress && $user->currentStaffAddress->count() > 0) ? $user->currentStaffAddress->first() : $defaultaddress;
                    }
                }else if( in_array(Auth::user()->role_id , $agentRole) ){
                    if($orderFor == 'customer'){
                        $defaultaddress = ($user->defaultAgentCustomerAddress != '' && $user->defaultAgentCustomerAddress != null) ? $user->defaultAgentCustomerAddress : $user->agentCustomerReceivers()->first();
                        $current_address = ($user->currentAgentCustomerAddress && $user->currentAgentCustomerAddress->count() > 0) ? $user->currentAgentCustomerAddress->first() : $defaultaddress;
                    }else{
                        $defaultaddress = ($user->defaultAgentAddress != '' && $user->defaultAgentAddress != null) ? $user->defaultAgentAddress : $user->agentReceivers()->first();
                        $current_address = ($user->currentAgentAddress && $user->currentAgentAddress->count() > 0) ? $user->currentAgentAddress->first() : $defaultaddress;
                    }
                }else{
                    $defaultaddress = ($user->defaultaddress) ? $user->defaultaddress : $user->address()->first();
                    $current_address = ($user->current_address->count() > 0) ? $user->current_address->first() : $defaultaddress;
                }

                $shipping_companies = Helper::getShippingCompanies($result,$current_address);
                // dd(Helper::getShippingCompanies($result,$current_address));
                if(is_string($shipping_companies) || !is_a($shipping_companies['shipping_companies'], 'Illuminate\Database\Eloquent\Collection') || $shipping_companies['shipping_companies']->count() == 0){
                    \Session::flash('error', 'Shipping not available in this state or address for '.$seller->name.' products');
                    return redirect()->back()->withInput(['tab' => 'addresses']);
                }
                $result['shipping_company'] = (isset($shipping_companies['shipping_company'])) ? $shipping_companies['shipping_company'] : $shipping_companies['shipping_companies'][0];
                $result['shipping_companies'] = $shipping_companies['shipping_companies'];
                $sellerVoucher = Seller::with(['vouchers' => function($q) use($sellertotal) {
                                    $q->where('min_basket_price', '<=', $sellertotal);
                                }])->find($key);     

                $result['vouchers'] = ($sellerVoucher) ? $sellerVoucher->vouchers : [];
                $cartitem[] = $result;

            }

            // $productIds = array_column($result['products'], 'product_id');

            $sub_total  = $amount;
            $promotion  = Session::get('promotion');
            $voucherId   = Helper::decrypt($request->dataId);
            $coupon = Voucher::find($voucherId);
            $voucherData = Helper::getVoucherData($voucherId, $sub_total, $productIds);
            $voucherProductID = $voucherData['productID'];

            $qtyOfProduct = array_reduce($productDataArray, function($carry, $item) use($voucherProductID) {
                if ($item['product_id'] == $voucherProductID)
                    $carry = $item;
                return $carry;
            });

            $productsIds = array_column($productDataArray, 'product_id');
            $vouchersOfProducts = VoucherProduct::whereIn('product_id', $productsIds)->get()->groupBy('voucher_id')->toArray();

            $voucherProductID = $voucherData['productID'];
            $discountType = $voucherData['discountType'];
            $voucherDiscount = ($discountType == 'by_percentage') ? ($voucherData['discount'] * $qtyOfProduct['qty']) :  $voucherData['discount'];
            $voucherCashback = ($discountType == 'by_percentage') ? ($voucherData['cashback'] * $qtyOfProduct['qty']) :  $voucherData['cashback'];
            if($coupon && $coupon->max_discount_price_type == 'limit'){
                $voucherDiscount = (($voucherData['discount'] * $qtyOfProduct['qty']) > $coupon->max_discount_price) ? $coupon->max_discount_price: ($voucherData['discount'] * $qtyOfProduct['qty']);
                $voucherCashback = (($voucherData['cashback']) > $coupon->max_discount_price) ? $coupon->max_discount_price: ($voucherData['cashback']);
            }

            $categories = $product->categories->pluck('category_id');

            $setPromotionVoucherId = '';
            $setPromotionSellerTotal = '';
            $setPromotionSellerId = '';
            if($promotion){
                $promotionVoucherId   = Helper::decrypt($promotion['voucher_id']);
                if($promotion['type'] == 'seller'){
                    $setPromotionVoucherId = Helper::decrypt($promotion['voucher_id']);
                    $setPromotionSellerId = $promotion['seller_id'];
                    $setPromotionSellerTotal = $promotion['total'];
                    $voucherData = Helper::getSellerVoucherDiscount($promotionVoucherId, $setPromotionSellerTotal);
                    $voucherDiscount = $voucherData['discount'];
                    $voucherCashback = $voucherData['cashback'];
                }
            }

            $sameSellerProducts   = Product::whereHas('categories')
            ->where('seller_id',$product->seller_id)
            ->inRandomOrder()
            ->limit(4)->get();

            if(count($categories) > 0){
                $categoryProducts = Product::whereHas('categories',function($query) use ($categories){
                    $query->where('category_id',$categories);
                })->inRandomOrder()->limit(8)->get();
            }else{
                $categoryProducts = Product::where('name','like','%'.$product->name.'%')->inRandomOrder()->limit(8)->get();
            } 

            $usedvariations = $cart = Cart::wherehas('productdetails')
            ->where('user_id', $user->id)
            ->pluck('variation_id')->toArray();

            $coinsData = [];
            $coinsData['usedRM'] = isset($requestData['usedRM']) ? $requestData['usedRM'] : 0;
            $coinsData['usedCoins'] = isset($requestData['usedCoins']) ? $requestData['usedCoins'] : 0;

            $customerAddresses      = [];
            $defaultCustomerAddress = [];
            $customerCurrentAddress = [];
            if($orderFor == 'customer'){
                if($user->role_id == '15'){
                    $customerAddresses = $user->staffCustomerReceivers;
                    $defaultCustomerAddress = $user->staffCustomerReceivers()->first();
                    if(!$defaultCustomerAddress){
                        $address = Staffreceiver::create([
                            'staff_id' => $user->id,
                            'name' => $user->name,
                            'contact_no' => $user->contact_number,
                            'countrycode' => '+60',
                            'address_line1' => $user->state,
                            'address_line2' => $user->state,
                            'state' => $user->state,
                            'town' => '',
                            'postal_code' => '',
                            'country' => '',
                            'address_for' => 0,
                            'is_default' => 1,
                        ]);
                    }
                    $customerCurrentAddress = ($user->currentStaffCustomerAddress && $user->currentStaffCustomerAddress->count() > 0) ? $user->currentStaffCustomerAddress : $defaultCustomerAddress;
                }else{
                    $customerAddresses = $user->agentCustomerReceivers;
                    $defaultCustomerAddress = $user->agentCustomerReceivers()->first();
                    if(!$defaultCustomerAddress){
                        $address = Agentreceiver::create([
                            'agent_id' => $user->id,
                            'name' => $user->name,
                            'contact_no' => $user->contact_number,
                            'countrycode' => '+60',
                            'address_line1' => $user->state,
                            'address_line2' => $user->state,
                            'state' => $user->state,
                            'town' => '',
                            'postal_code' => '',
                            'country' => '',
                            'address_for' => 0,
                            'is_default' => 1,
                        ]);
                    }
                    $customerCurrentAddress = ($user->currentAgentCustomerAddress && $user->currentAgentCustomerAddress->count() > 0) ? $user->currentAgentCustomerAddress : $defaultCustomerAddress;
                }
            }
            return view('frontend.checkout', compact('cartitem','bundleId', 'bundleDiscount', 'cartContainBundleProduct','amount','sameSellerProducts','categoryProducts','sub_total','totalitems','usedvariations', 'voucherDiscount', 'voucherCashback', 'voucherId', 'coinsData', 'orderFor', 'customerAddresses', 'defaultCustomerAddress','customerCurrentAddress','cartProductIds', 'productDataArray', 'setPromotionVoucherId', 'setPromotionSellerTotal', 'setPromotionSellerId', 'vouchersOfProducts', 'current_address', 'sellerIDs'));
        } else {
            \Session::flash('error', trans('messages.cartproduct'));
            return redirect()->route('home');
        }
    }

    /* get address html */
    public function getaddresshtml(Request $request){
        $user = Auth::user();
        $address_id     = Helper::decrypt($request->address_id);
        if($user->role_id == '7'){
            $user->address()->where('current_address',1)->update(['current_address' => 0]);
            $defaultaddress = UserAddress::find($address_id);
        }elseif($user->role_id == '15'){
            $user->staffCustomerReceivers()->where('current_address',1)->update(['current_address' => 0]);
            $defaultaddress = Staffreceiver::find($address_id);
        }else{
            $user->agentCustomerReceivers()->where('current_address',1)->update(['current_address' => 0]);
            $defaultaddress = Agentreceiver::find($address_id);
        }
        $view           = view('frontend.address')->with(compact('defaultaddress'))->render();
        $defaultaddress->update(['current_address' => 1]);

        return response()->json([
            'status' => 200, 'view' => $view]
        );
    }

    /* place order */
    public function placeorder(Request $request){
        $user = Auth::user();

        $validator = Validator::make(
            $request->all(),
            array(
                "payment_method" => "required",
                "shipping_company" => "required"
            ),
            [
                'payment_method.required' => trans('messages.payment_method.required'),
            ]
        );

        if ($validator->fails()) {
            $msg = $validator->errors()->getMessages();
            $ms = "Validation error";
            foreach ($msg as $key => $value) {
                $ms = $value[0];
            }
            \Session::flash('error', $ms);
            return redirect()->back();
        }

        $bundleAmount = 0;
        $bundleDiscount = 0;
        $cartData = Cart::select('id','bundle_deal_id','product_id', 'qty')->with('bundleDeal')->where('user_id', $user->id)->get();
        $cartProductIds = array_column($cartData->toArray(), 'product_id');
        $bundleId = $cartData->groupBy('bundle_deal_id')->toArray();
        $bundleId = key($bundleId);
        $bundleProductIds = [];
        if($bundleId && $bundleId > 0){
            $bundleDealProductData = BundleDeal::with('BundleDealProducts')->find($bundleId);
            if($bundleDealProductData && $bundleDealProductData->BundleDealProducts && count($bundleDealProductData->BundleDealProducts) > 0){
                $bundleProducts = $bundleDealProductData->BundleDealProducts;
                $bundleProductIds = $bundleProducts->pluck('product_id')->toArray();
                foreach($bundleProductIds as $bundleProductId){
                    $product = Product::where('id', $bundleProductId)->first();
                    $variationId = $product->is_variation == '1' ? $product->variation->id : null;
                    $bundleAmount = $bundleAmount + $product->getcustomerproductprice($user, $bundleProductId, 1, $variationId);  
                }
                $bundleDiscount = ($bundleAmount * $bundleDealProductData->discount)/100;
            }
        }

        $cart = Cart::wherehas('productdetails', function ($query) {
                        $query->where('is_deleted', '0')
                        ->where('status', "active");
                    })->with('variation')
                    ->where('user_id', $user->id)
                    ->where('status', "active")
                    ->get()
                    ->map(function($item){
                        $item->variation_value = $item->variation;
                        unset($item->variation);
                        return $item;
                    })->groupBy('seller_id');

                    

        if (count($cart) != 0) {
            $cartItems = Cart::wherehas('productdetails', function ($query) {
                                    $query->where('is_deleted', '0')
                                    ->where('status', "active");
                                })->where('status', "active")->where('user_id', $user->id)->get();

            if (count($cartItems) <= 0) {
                \Session::flash('error', trans('messages.notfoundcart'));
                return redirect()->back();
            }
            $discount = 0;
            $weight = 0;
            $shippingCharge = 0;
            if($user->role_id == '7'){
                $address = UserAddress::where('id', Helper::decrypt($request->address[0]))->first();
            }elseif($user->role_id == '15'){
                $address = Staffreceiver::where('id', Helper::decrypt($request->address[0]))->first();
            }else{
                $address = Agentreceiver::where('id', Helper::decrypt($request->address[0]))->first();
            }
            $state = $address->state;   
            $state = State::where('name',$state)->first();
             if($state == null){
                    \Session::flash('error', 'Shipping method not available!');
                    return redirect()->route('viewcart');
                }
            if ($cartItems != null) {
                $cod_avail = [];
                $total = 0;
                foreach ($cartItems as $value) {
                    $product = Product::where('id', $value->product_id)->first();
                    if (!empty($cod_avail) && !in_array($product->cod, $cod_avail)) {
                        //return response()->json(['success' => false, 'message' => trans('messages.chooseproductwithsameshippingmethod'), "code" => 500], 500);
                    }
                    $cod_avail[] = $product->cod;

                    if($value->variation_id != null && $value->variation_id != ''){
                        $variation = AttributeVariationPrice::find($value->variation_id);
                        $qty = $variation->qty;
                    }else{
                        $qty = $product->qty;
                    }

                    if ($qty < $value->qty || $product->is_deleted == 1) {
                        \Session::flash('error', trans('messages.productnothaveqty'));
                        return redirect()->back();
                    }
                    if ($product->free_shipping == '0') {
                        $product_weight = $product->weight * $value->qty;
                        $weight = $weight + $product_weight;
                    }
                    $amount = $product->getcustomerproductprice($user, $value->product_id, $value->qty,$value->variation_id);

                    $total += $amount * $value->qty;
                    
                }
                foreach($request->shipping_company as $company){

                    if($company == null){
                        \Session::flash('error', 'Shipping method not available!');
                        return redirect()->back();
                    }
                }
                if($request->shipping_company[0] == null){
                    \Session::flash('error', 'Shipping method not available!');
                    return redirect()->back();
                }

                $shippingmethod = Helper::getShippingCharge($address, $weight, $user,$cart,$request->shipping_company);
                if(!$shippingmethod){
                    \Session::flash('error', 'Shipping method not available!');
                    return redirect()->back();
                }

                $shippingChargeActual = 0;
                $shippingAgent = 0;
                $shippingStaff = 0;

                foreach($shippingmethod as $company){
                    if(empty($company[0])){
                        \Session::flash('error', 'No shipping available.');
                        return redirect()->back();
                    }
                    $shippingCharge += array_sum(array_column($company[0], 'price'));
                    $shippingChargeActual += array_sum(array_column($company[0], 'actual_price'));
                    $shippingAgent += array_sum(array_column($company[0], 'agent_price'));
                    $shippingStaff += array_sum(array_column($company[0], 'staff_price'));
                }
                
                if (!empty($request->transaction_id)) {
                    $transaction_id = $request->transaction_id;
                } else {
                    $transaction_id = uniqid();
                }
                
                $total += $shippingCharge;

             
                      // $productIds = [];
                // foreach($cartItems as $cartItem) {
                //     array_push($productIds, $cartItem->product_id);
                // }

                $shopVoucherDiscount = 0;
                // if($request->has('discountData') && count($request->discountData) > 0){
                //     $shopVoucherDiscount = array_sum($request->discountData);
                // }

                // $voucherData = $request->has('voucher_id') ? Helper::getVoucherData($request->voucher_id, $total, $productIds) : [];

                $cashback = 0;
                $productVoucherDiscount = 0;
                // if($voucherData && count($voucherData) > 0){
                //     $cashback = $voucherData['cashback'];
                //     $productVoucherDiscount = $voucherData['discount'];
                // }
                $usedCoins = $request->has('used_coins') ? $request->used_coins : 0;
                $usedCoinsInRm = $request->has('used_coins_in_rm') ? (double)($request->used_coins_in_rm) : 0;
                $coinManagement = CoinManagement::first();
                $coinRate = $coinManagement ? $coinManagement->coin_to_rm : 0;
                if($request->finalDeductionType == 'discount'){
                    $discount = $request->finalDiscount;
                }

                if($request->finalDeductionType == 'cashback'){
                    $cashback = $request->finalCashback;
                }

                $checkTotalWithBalance = $total - $discount - $usedCoinsInRm;

                if ($request->payment_method == 3) {
                    if ($user->wallet_amount < $checkTotalWithBalance) {
                        // \Session::flash('error', trans('messages.donthavebal'));

                        // return redirect()->back();
                    }
                }
                // dd($request->finalDeductionId);
                $order = Order::create([
                    'user_id' => $user->id,
                    'parent_id' => $user->parent->id,
                    'role_id' => $user->role_id,
                    // 'courier_company_name' => ($request->shipping_company != "") ? $request->shipping_company : 0,
                    'shipping_fees_paid_by' => ($user->parent->role_id < 7) ? 'agent' : 'company',
                    'status' => "pending",
                    'payment_by' => $request->payment_method,
                    'transaction_id' => $transaction_id,
                    'shipping_charge' => $shippingCharge,
                    'bank_id' => ($request->bank_id != "") ? $request->bank_id : 0,
                    // 'coupon_id' => isset($request->coupon_id) ? $request->coupon_id : 0,
                    'coupon_id' => isset($request->finalDeductionId) ? Helper::decrypt($request->finalDeductionId) : 0,
                    'discount' => $discount + $bundleDiscount + $shopVoucherDiscount,
                    // 'product_discount' => $productVoucherDiscount,                    
                    // 'product_cashback' => $cashback,                    
                    'shipping_details' => json_encode($shippingmethod),
                    'used_coins' => $usedCoins,
                    'used_coins_in_rm' => $usedCoinsInRm,
                    'coin_rate' => $coinRate,
                ]);
                if($shippingChargeActual > $shippingCharge){
                    if($user->parent && $user->parent->role_id < 7){
                        $order->update(['shipping_paid_by_agent' => ($shippingAgent)]);
                    }else{
                        $order->update(['shipping_paid_by_company' => ($shippingChargeActual - $shippingCharge)]);
                    }
                }
                if($user->parent && $user->parent->role_id == 15){
                    $order->update(['shipping_paid_by_staff' => ($shippingStaff)]);
                }
                foreach($shippingmethod as $company){
                    $value = array_values($company[0])[0];
                    $order->counriercompanies()->create(['seller_id' => $value['seller_id'], 'price' => $value['price'], 'shipping_company' => $value['shipping_company']  ,'detail'=>json_encode($value)]);
                }

                foreach($shippingmethod[0][0] as $key => $shipping){
                    if($shipping['tracking_number'] > 1){
                        for($i=0;$i < $shipping['tracking_number']; $i++){
                            $order->tracking_no()->create(['seller_id' => $key, 'price' => $shipping['price'], 'tracking_number' => '' ]);
                        }
                    }else{
                        $order->tracking_no()->create(['seller_id' => $key, 'price' => $shipping['price'], 'tracking_number' => '' ]);
                    }
                }

                $order = Order::where('id', $order->id)->first();
                $order->order_id = "ORDER" . sprintf("%06d", $order->id);
                /** Uploading bank receipt for manual bank payment method */
                $order->save();

                if($request->has('finalDeductionId') && $request->voucherId != '' && $request->finalDeductionId > 0 && $request->finalDeductionId != ''){
                    // foreach($request->voucherId as $key => $shopVoucher){
                    //     if($request->cashbackData[$key] > 0 && $request->cashbackData[$key] != null){
                    //         // $userCashback = User::where('id', $user->id)->first();
                    //         // $userCashback->coin_balance = $userCashback->coin_balance + $request->cashbackData[$key];
                    //         // $userCashback->save();
                    //     }
                    // }
                    $voucherType = Helper::getVoucherType($request->finalDeductionId);
                    $editVoucher = Voucher::find($request->finalDeductionId);
                    if($editVoucher){
                        $editVoucher->usage_qty = $editVoucher->usage_qty - 1;
                        $editVoucher->update();
                    }

                    $orderVoucher = new OrderVoucher();
                    $orderVoucher->order_id = $order->id;
                    $orderVoucher->voucher_type = $voucherType;
                    $orderVoucher->reference_id = $request->has('referenceId') ? $request->referenceId : '';
                    $orderVoucher->voucher_id = $request->finalDeductionId;
                    $orderVoucher->discount = $discount;
                    $orderVoucher->cashback = $cashback;
                    $orderVoucher->save();                  
                }
                if ($request->payment_method == 3) {
                    $userwallet = User::where('id', $user->id)->first();
                    if ($user->wallet_amount >= $checkTotalWithBalance) {
                        $userwallet->wallet_amount = $userwallet->wallet_amount - $checkTotalWithBalance;
                        $userwallet->save();
                        $userwallet->decrement('coin_balance',$usedCoins);
                    }else{
                        $order->status = 'pending_payment';
                        $order->save();
                    }
                }

                if ($address != null) {
                    if ($address->is_default != "true") {
                        if($user->role_id == '7'){
                            $falseaddress = UserAddress::where('user_id', $user->id)->update(['is_default' => "false"]);
                        }elseif($user->role_id == '15'){
                            $falseaddress = Staffreceiver::where('staff_id', $user->id)->update(['is_default' => "false"]);
                        }else{
                            $falseaddress = Agentreceiver::where('agent_id', $user->id)->update(['is_default' => "false"]);
                        }
                        $address->is_default = "true";
                        $address->save();
                    }
                    $contactNumber = $address->contact_number ? $address->contact_number : $address->contact_no;
                    $countryCode = $address->country_code ? $address->country_code : $address->countrycode;
                    $orderaddress = OrderAddress::create([
                        'order_id' => $order->id,
                        'name' => $address->name,
                        'contact_number' => $contactNumber,
                        'address_line1' => $address->address_line1,
                        'address_line2' => $address->address_line2,
                        'state' => $address->state,
                        'town' => $address->town,
                        'postal_code' => $address->postal_code,
                        'country' => $address->country,
                        'country_code' => $countryCode,
                    ]);
                }

                $totalamount = $shippingCharge;
                $agent_price_amount = 0;

                foreach ($cartItems as $value) {
                    $product = Product::where('id', $value->product_id)->first();
                    $amount = $product->getcustomerproductprice($user, $value->product_id, $value->qty,$value->variation_id);
                    $agentamount = $product->get_product_price($user->parent, $value->product_id,$value->variation_id);

                    $qtyamount = $amount * $value->qty;
                    $totalamount = $totalamount + $qtyamount;
                    $agentqtyamount = $agentamount * $value->qty;

                    $agentquantityamount = $agent_price_amount + $agentqtyamount;
                    $agent_price_amount = $agent_price_amount + $agentquantityamount;
                    $orderprouct = OrderProduct::create([
                                        'order_id' => $order->id,
                                        'product_id' => $value->product_id,
                                        'qty' => $value->qty,
                                        'price' => $amount,
                                        'product_info' => json_encode($product),
                                        'status' => $product->status,
                                        'customer_qty_price' => $product->getcustomerproductprice(null, $value->product_id, $value->qty, $value->variation_id),
                                        'agent_price' => $agentamount,
                                        'agent_qty_price' => $agentqtyamount,
                                        'cost_price' => $product->cost_price,
                                        'variation_id' => ($value->variation_id) ? $value->variation_id : 0,
                                        'seller_id' => $value->seller_id,
                                        'shocking_sale' => $product->shocking_sell
                                    ]);
                  
                    if($value->variation_id != '' && $value->variation_id != null){
                        $variation = AttributeVariationPrice::find($value->variation_id);
                        $variation->qty = $variation->qty - $value->qty;
                        $orderprouct->shocking_sale = $product->shocking_sell;
                        $orderprouct->save();
                        $variation->update();
                    }else{
                        $product->qty = $product->qty - $value->qty;
                    }
                    $product->save();
                }
                $totalamount = round($totalamount - $discount - $bundleDiscount - $shopVoucherDiscount - $usedCoinsInRm, 2);

                // if($request->has('voucher_id')){
                //     $editProductVoucher = Voucher::find($request->voucher_id);
                //     if($editProductVoucher){
                //         $editProductVoucher->usage_qty = $editProductVoucher->usage_qty - 1;
                //         $editProductVoucher->update();
                //     }
                // }
                $voucherDiscount = 0;
                $cashback = 0;
                // if($voucherData && count($voucherData) > 0){
                //     $voucherDiscount = $voucherData['discount'];
                //     $cashback = $voucherData['cashback'];
                // }

                $order->total_amount = round($totalamount - $voucherDiscount, 2);
                if ($totalamount < 0) {
                    \Session::flash('error', 'Something went wrong!');
                    return redirect()->route('home');
                }
                $order->save();

                if ($cashback > 0) {
                    // $userCashback = User::where('id', $user->id)->first();
                    // $userCashback->coin_balance = $userCashback->coin_balance + $cashback;
                    // $userCashback->save();
                }
                if ($request->payment_method == 3) {
                    if ($user->wallet_amount > $checkTotalWithBalance && $user->role_id == 7) {
                        Transactionhistoriescustomer::create([
                            'user_id' => $user->id,
                            'order_id' => $order->id,
                            'status' => $order->status,
                            'transaction_id' => $order->transaction_id,
                            'transaction_for' => "payment",
                            'amount' => '-' . round($totalamount),
                            'payment_by' => $request->payment_method,
                        ]);
                    }elseif ($user->wallet_amount > $checkTotalWithBalance && $user->role_id == 15){
                        Transactionhistoriesstaff::create([
                            'user_id' => $user->id,
                            'order_id' => $order->id,
                            'wallet_id' => $wallet,
                            'status' => "accept",
                            'transaction_id' => $order->transaction_id,
                            'transaction_for' => "payment",
                            'amount' => '-' . round($totalamount),
                            'payment_by' => $request->payment_method,
                            'comment' => "Payment for Order",
                        ]);
                    }elseif ($user->wallet_amount > $checkTotalWithBalance){
                        Transactionhistoriesagent::create([
                            'order_id' => $order->id,
                            'user_id' => $user->id,
                            'status' => "accept",
                            'transaction_for' => 'payment',
                            'transaction_id' => $order->transaction_id,
                            'amount' => '-' . round($totalamount),
                            'payment_by' => $request->payment_method,
                            'comment' => "Payment for Order",
                        ]);
                    }
                }
                $cart = Cart::where('user_id', $user->id)->where('status', "active")->delete();
                if($order->status != 'pending_payment'){
                    \Session::flash('success', trans('messages.orderplaced'));
                }
                // if($request->payment_method == '2'){
                //     $order->status = 'pending_payment';
                //     $order->save();
                //     $merchant_code = config('services.IPAY_MERCHANT_CODE');
                //     $refno     = $order->order_id;
                //     $signature = PaymentHelper::requestSignature($refno,1);
                //     $responseURL   = route('thankyou');
                //     $backendUrl    = route('ipaycallback');
                //      $amount    = 1;//round($totalamount,2);
                //      $currency  = 'MYR';

                //      return view('frontend.ipaypayment', compact('merchant_code','refno','signature','responseURL','backendUrl','amount','currency'));
                //  }
                $promotion  = Session::get('promotion');

                if($promotion){
                    $voucherId   = Helper::decrypt($promotion['voucher_id']);
                    UserVoucher::where('voucher_id',$voucherId)->update(['status' => 1]);
                }

                session()->forget('cart_request_data');
                $request->session()->forget('cartItems');
                $request->session()->forget('promotion');
                return redirect()->route('user.orders.view',$order->order_id);
             }

         }
    }

     /* change shipping methods */
    public function changeShippingMethod(Request $request){
        // dd($request->all());
        $id = Helper::decrypt($request->shippingmethod);
        $seller = Helper::decrypt($request->seller);
        // $shipping_company = session()->get('shippingmethod');
        $shipping_company[$seller] = [
            "shipping_company" => $id
        ];
        session()->put('shippingmethod', $shipping_company);
        return response()->json(['success' => true, 'message' => 'Shipping method changed.', "code" => 200], 200);
    }

    /* thank you */
    public function thankyou(Request $request)
    {
        $order = Order::where('order_id',$request->RefNo)->first();
        $order->update(['transaction_id' => $request->TransId, 'status' => ($request->Status == "0") ? 'rejected' : 'pending','cancel_order_reason' => ($request->Status == "0") ? $request->ErrDesc : '']);
        if($request->Status == "0"){
            \Session::flash('error', $request->ErrDesc);
        }
        return view('frontend.thankyou');
    }

    /* order detail */
    public function viewOrderDetail(Request $request,$order_id)
    {
        // $validator = Validator::make(
        //     $request->all(),
        //     array(
        //         "order_id" => "required",
        //     ),
        //     [
        //         'order_id.required' => trans('messages.order_id.required'),
        //     ]
        // );

        // if ($validator->fails()) {
        //     $msg = $validator->errors()->getMessages();
        //     $ms = "Validation error";
        //     foreach ($msg as $key => $value) {
        //         $ms = $value[0];
        //     }
        //     \Session::flash('error', $ms);
        //     return redirect()->back();
        // }

        $order = Order::with('OrderAddress', 'coupon:id,code', 'orderVouchers', 'orderVouchers.voucher', 'productVoucher')->select('id', 'created_at', 'status', 'shipping_charge', 'order_id', 'payment_by', 'courier_company_name', 'tracking_number', 'cancel_order_reason', 'remark', 'coupon_id', 'discount', 'product_discount','product_cashback','used_coins_in_rm', 'used_coins')
                //->where('user_id',$user->id)
                ->where('order_id', $order_id)
                ->first();

        if(!$order){
            return redirect()->back();
        }
        $orderVoucherDiscount = $orderVoucherCashback = [];
        $sellerDiscount = $sellerCashback = 0;
                
        if($order && $order->orderVouchers && count($order->orderVouchers) > 0){
            $orderVoucherDiscount = array_column((array)$order->orderVouchers, 'discount');
            $orderVoucherCashback = array_column((array)$order->orderVouchers, 'cashback');
            foreach($order->orderVouchers as $key) {
                $orderVoucherDiscount[] = $key["discount"];
                $orderVoucherCashback[] = $key["cashback"];
            }
            $sellerDiscount = array_sum($orderVoucherDiscount);
            $sellerCashback = array_sum($orderVoucherCashback);
        }

        $locale = app()->getLocale();

        $order->amount = $order->getorderpricebyid($order->id);
        $order->courier_company = $order->courier_companydetails;
        $products = $order->getproductsdetails($order->id)->groupBy('seller_id');
        $result = [];
        $response = [];
        $address = \DB::table('order_addresses')
                ->where('order_addresses.order_id', '=', $order->id)
                ->get();
        $i = 0;
            $sub_total = 0;
        foreach ($products as $key => $sellerarr) {
            $key = (!$key) ? 1 :$key;
            $totalitems = 0;
            $seller = Seller::find($key);
            $sellertotal = 0;

            $result[$i]['seller_id'] = $response['seller_id'] = ($seller) ? $seller->id : '';
            $result[$i]['seller_name'] = ($seller) ? $seller->name : '';
            $result[$i]['image'] = ($seller) ? $seller->image : '';
            $product_array = [];
            $current_address = $order->orderAddress;
            $shippingmethod = OrderShipping::where('order_id',$order->id)->where('seller_id',$seller->id)->first();
            // $shippingmethod = ($shippingmethod) ? $shippingmethod->shippingcomapny : null;

            foreach ($sellerarr as $value) {
                $product = Product::where('id', $value->product_id)->with('images')->first();
                // dd($value);
                $product_info = json_decode($value->product_info);
                $product_info->images = $product->images;
                // $product_info->image = $product->image;
                $product_info->id   = $value->id;
                $product_info->product_id   = $value->product_id;
                $product_info->qty   = $value->qty;
                $product_info->qty   = $value->qty;
                $product_info->variation_id   = $value->variation_id;
                $product_info->variation   = $value->variation;

                // $p['product_name']  = $product->printproductname($locale, $product->id);
                // $p['product_id']    = $value->product_id;
                // $p['product_price'] = $value->price;
                // $p['cod']   = $product->cod;
                $product_array[]    = $product_info;
                $totalitems += $value->qty;
                $product_total = $value->qty * $product_info->sell_price;
                if($product_info->variation_id > 0){

                    $product_total = $value->qty * $product_info->variation->sell_price;
                }
                $sellertotal += $product_total;
                $sub_total += $product_total;

            }
            $result[$i]['totalitems'] = $totalitems;
            $result[$i]['seller_total'] = $sellertotal;
            // $result[$i]['sub_total'] = $totalitems;

            $result[$i]['products'] = $response['products'] = $product_array;
            $result[$i]['shipping_company'] = $response['shipping_company'] = $shippingmethod;
            // $result[$i]['shipping_companies'] = Helper::getShippingCompanies($response,$current_address);
            // $response['products'] = $order->orderProduct;
            $i++;
        }

        $order->products = $result;
        // dd($result);

        $order->invoice_path = $order->print_invoice($order->order_id);
        if (!$order->coupon) {
            unset($order->coupon);
            $order->coupon = (object) null;
        }
        return view('profile.orders.detail',compact('order','result','sub_total','address', 'sellerDiscount','sellerCashback'));
    }

    public function payByWallet(Request $request,$order_id)
    {
        $user = Auth::user();
        $order = Order::where('user_id',$user->id)
                ->where('order_id', $order_id)
                ->first();
        $total = $order->total_amount;
        if($total > $user->wallet_amount){
             \Session::flash('error', trans('messages.donthavebal'));
            return redirect()->back();
        }
        $user->wallet_amount = $user->wallet_amount - $total;
        $user->save();
        
        $order->status = 'pending';
        $order->save();
        \Session::flash('success', 'Payment completed successfully');
        return redirect()->back();

        // dd($order->total_amount+$order->shipping_charge);
    }

    /* cancel order */
    public function cancelorder(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make(
            $request->all(),
            array(
                "order_id" => "required",
                "reason" => "required",
            ),
            [
                'order_id.required' => trans('messages.order_id.required'),
                'reason.required' => trans('messages.reasonrequired'),
                'reason.min' => trans('messages.reasonmin'),
            ]
        );
        if ($validator->fails()) {
            $msg = $validator->errors()->getMessages();
            $ms = "Validation error";
            foreach ($msg as $key => $value) {
                $ms = $value[0];
            }
            \Session::flash('success', $ms);
            return redirect()->back();
        }
        $order = Order::where('order_id', $request->order_id)->first();
        if ($order->status == "pending" || $order->status == "pending_payment") {
            /*meanse wallet*/
            if ($order->payment_by == 3 && $order->status == "pending") {
                    if ($order->role_id == 15) {
                        $history = Transactionhistoriesstaff::where('transaction_for', "payment")->where('order_id', $request->order_id)->first();
                        $amount = preg_replace('#[-]#', "", $history->amount);
                        $userwallet = User::where('id', $order->user_id)->first();
                        $userwallet->wallet_amount = $userwallet->wallet_amount + $amount;
                        $userwallet->coin_balance = $userwallet->coin_balance + $order->used_coins;
                        $userwallet->save();
                        /*store in history*/
                        Transactionhistoriesstaff::create([
                            'order_id' => $order->id,
                            'user_id' => $order->user_id,
                            'status' => 'accept',
                            'transaction_for' => 'refund',
                            'transaction_id' => time(),
                            'amount' => $amount,
                            'payment_by' => null,
                            'wallet_id' => '1',
                            'comment' => "Refund",
                        ]);
                    } elseif($order->role_id == 7){
                        $history = Transactionhistoriescustomer::where('transaction_for', "payment")->where('order_id', $order->id)->first();
                        $amount = preg_replace('#[-]#', "", $history->amount);
                        $userwallet = User::where('id', $order->user_id)->first();
                        $userwallet->wallet_amount = $userwallet->wallet_amount + $amount;
                        $userwallet->coin_balance = $userwallet->coin_balance + $order->used_coins;
                        $userwallet->save();
                        /*store in history*/
                        Transactionhistoriescustomer::create([
                            'user_id' => $user->id,
                            'order_id' => $order->id,
                            'status' => 'accept',
                            'transaction_id' => time(),
                            'transaction_for' => 'refund',
                            'amount' => '-' . round($amount),
                            'payment_by' => null,
                        ]);
                    } else {
                        $history = Transactionhistoriesagent::where('transaction_for', "payment")->where('order_id', $request->order_id)->first();
                        $amount = preg_replace('#[-]#', "", $history->amount);
                        $userwallet = User::where('id', $order->user_id)->first();
                        $userwallet->wallet_amount = $userwallet->wallet_amount + $amount;
                        $userwallet->coin_balance = $userwallet->coin_balance + $order->used_coins;
                        $userwallet->save();
                        /*store in history*/
                        Transactionhistoriesagent::create([
                            'order_id' => $order->id,
                            'user_id' => $order->user_id,
                            'status' => 'accept',
                            'transaction_for' => 'refund',
                            'transaction_id' => time(),
                            'amount' => $amount,
                            'payment_by' => null,
                            'wallet_id' => '1',
                            'comment' => "Refund",
                        ]);
                    }

            }
            foreach($order->orderProduct as $orderproduct){
                if($orderproduct->variation_id != 0){
                    $product = AttributeVariationPrice::find($orderproduct->variation_id);
                    $product->increment('qty',$orderproduct->qty);
                }else{
                    $product = Product::find($orderproduct->product_id);
                    $product->increment('qty',$orderproduct->qty);
                }
            }
            $order->status = "cancelled";
            $order->cancel_order_reason = $request->reason;
            $order->save();
           
            $user = $order->user;
            
            // Notification::send($user, new OrderCancelled($order->order_id));
            NotificationHelper::send_pushnotification($user, 'Order Cancelled', 'Your order cancelled', 0, $order->id);
            PushNotification::create(['receiver_id' => $user->id, 'sender_id' => 1, 'message' => 'order cancelled', 'type' => 'order_cancelled', 'order_id' => $order->id]);
            \Session::flash('success', trans('messages.ordercancel'));
            return redirect()->back();
        } else {
            \Session::flash('error', trans('messages.orderpending'));
            return redirect()->back();
        }

    }

    /* edit order */
    public function editOrder($order_id, $updated = false)
    {
        $order = Order::with('OrderAddress', 'coupon:id,code')->select('id', 'created_at', 'status', 'shipping_charge', 'order_id', 'payment_by', 'courier_company_name', 'tracking_number', 'cancel_order_reason', 'remark', 'coupon_id', 'discount')
                //->where('user_id',$user->id)
                ->where('order_id', $order_id)
                ->first();
        if($order->status != 'pending'){
            \Session::flash('error', trans('messages.orderpending'));
            return redirect()->back();
        }

        $locale = app()->getLocale();

        $order->amount = $order->getorderpricebyid($order->id);
        $order->courier_company = $order->courier_companydetails;
        $products = $order->getproductsdetails($order->id)->groupBy('seller_id');
        $result = [];
        $response = [];
        $address = \DB::table('order_addresses')
                ->where('order_addresses.order_id', '=', $order->id)
                ->get();
        $i = 0;
            $sub_total = 0;
        foreach ($products as $key => $sellerarr) {
            $totalitems = 0;
            $seller = Seller::find($key);
            $sellertotal = 0;

            $result[$i]['seller_id'] = $response['seller_id'] = ($seller) ? $seller->id : '';
            $result[$i]['seller_name'] = ($seller) ? $seller->name : '';
            $result[$i]['image'] = ($seller) ? $seller->image : '';
            $product_array = [];
            $current_address = $order->orderAddress;
            $shippingmethod = OrderShipping::where('order_id',$order->id)->where('seller_id',$seller->id)->first()->shippingcomapny;

            foreach ($sellerarr as $value) {
                // dd($value);
                $product = Product::where('id', $value->product_id)->with('images')->first();
                $product_info = json_decode($value->product_info);
                $product_info->images = $product->images;
                // $product_info->image = $product->image;
                if(!$updated){
                    $value->updated_qty = $value->qty;
                    $value->save();
                }
                $product_info->id   = $value->id;
                $product_info->product_id   = $value->product_id;
                $product_info->qty   = $value->qty;
                $product_info->updated_qty   = $value->updated_qty;
                $product_info->variation_id   = $value->variation_id;
                // $p['product_name']  = $product->printproductname($locale, $product->id);
                // $p['product_id']    = $value->product_id;
                // $p['product_price'] = $value->price;
                // $p['cod']   = $product->cod;
                // dd($product_info);
                $product_array[]    = $product_info;
                $totalitems += $value->updated_qty;
                $product_total = $value->updated_qty * $product->customer_price;
                $sellertotal += $product_total;
                $sub_total += $product_total;

            }
            // dd($sellertotal);
            $result[$i]['totalitems'] = $totalitems;
            $result[$i]['seller_total'] = $sellertotal;
            // $result[$i]['sub_total'] = $totalitems;

            $result[$i]['products'] = $response['products'] = $product_array;
            $result[$i]['shipping_company'] = $response['shipping_company'] = $shippingmethod;
            $result[$i]['shipping_companies'] = Helper::getShippingCompanies($response,$current_address);
            // $response['products'] = $order->orderProduct;
            $i++;
        }

        $order->products = $result;
        // dd($result);

        $order->invoice_path = $order->print_invoice($order->order_id);
        if (!$order->coupon) {
            unset($order->coupon);
            $order->coupon = (object) null;
        }
        return view('profile.orders.edit',compact('order','result','sub_total','address'));
    }

    /* update cart */
    public function updateqty(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                "order_product_id" => "required",
                "qty" => "required",
            ),
            [
                'order_product_id.required' => trans('messages.order_product_id.required'),
                'qty.required' => trans('messages.qtyreq'),
            ]
        );

        if ($validator->fails()) {
            $msg = $validator->errors()->getMessages();
            $ms = "Validation error";
            foreach ($msg as $key => $value) {
                $ms = $value[0];
            }
            return response::json(['success' => false, 'message' => $ms, "code" => 400], 400);
        }
        $order_product_id = Helper::decrypt($request->order_product_id);
        // echo $order_product_id;die();
        if(Auth::check()){

            $user = Auth::user();
            $cart = OrderProduct::where('id', (int)$order_product_id)->first();
            
            if ($cart->qty < $request->qty) {
                $product = Product::where('id', $cart->product_id)->first();
                if ($product->qty < $request->qty || $product->is_deleted == 1) {
                    return Response::json(["success" => false, "message" => trans('messages.requestqtynotavailable'), "code" => 400], 400);
                }
            }
            if (!empty($cart)) {
                $cart->updated_qty = $request->qty;
                $cart->save();
            }
        }
        return response::json(['success' => true, 'message' => trans('messages.qtyupdate'), "code" => 200], 200);
    }

    public function getProduct(Request $request){
        $product = Product::with('images')->where('id', $request->productId)->first();
        
        if($product){
            $product->image = $product->images[0]->image;
            return response::json(['success' => true, 'product' => $product, "code" => 200], 200);
        }
        return response::json(['success' => false, 'product' => 'no product found', "code" => 200], 200);
    }

    public function submitReview(Request $request){
        $checkExist = ReviewRating::where('order_product_id', $request->order_id)
                                    ->where('product_id', $request->product_id)->delete();

        $rating = new ReviewRating();
        $rating->order_product_id = $request->has('order_id') ? $request->order_id : null;
        $rating->product_id = $request->has('product_id') ? $request->product_id : null;
        $rating->user_id = Auth::user()->id;
        $rating->rate = $request->has('rating') ? $request->rating : null;
        $rating->review_type = $request->has('review_type') ? $request->review_type : null;
        $rating->description = $request->has('description') ? $request->description : null;
        $rating->check_anonymously = $request->has('check_anonymously') ? $request->check_anonymously : '0';

        if ($request->camera_img) {
            $image      = $request->file('camera_img');
            $file_name  = time() . '_review.' . $image->getClientOriginalExtension();
            $path   = "images/review/" . $file_name;
            $upload = Storage::disk('s3')->put($path, file_get_contents($image), 'public');
            $fileURL    = Storage::disk('s3')->url($path);
            $rating->image = $fileURL;
        }
        if ($request->video_img) {
            $image      = $request->file('video_img');
            $file_name  = time() . '_review_video.' . $image->getClientOriginalExtension();
            $path   = "images/reviewVideo/" . $file_name;
            $upload = Storage::disk('s3')->put($path, file_get_contents($image), 'public');
            $fileURL    = Storage::disk('s3')->url($path);
            $rating->video = $fileURL;
        }
        $rating->save();

        return response()->json([
            'success' => true , 'status' => 200, 'message' => 'Your review submitted'
        ]);
    }

    public function getVoucherData(Request $request){
        $name = Helper::getVoucherName($request->voucherId);
        $type = Helper::getVoucherType($request->voucherId);
        return response()->json([
            'success' => true , 'name' => $name, 'type' => $type
        ]);
    }

    public function updateFollower(Request $request){
        $userId = Auth::user()->id;
        $sellerId = $request->seller_id;

        $checkExist = SellerFollower::where('seller_id', $sellerId)->where('customer_id', $userId)->first();
        if($checkExist){
            $checkExist->delete();
            return response()->json([
                'success' => true , 'message' => 'Unfollowed successfully!', 'type' => 'unfollow'
            ]);
        }
        $sellerFollower = new SellerFollower();
        $sellerFollower->seller_id = $sellerId;
        $sellerFollower->customer_id = $userId;
        $sellerFollower->save();   
        return response()->json([
            'success' => true , 'message' => 'Following successfully!', 'type' => 'follow'
        ]);
    }

    public function checkCheckoutShipping(Request $request){
        $requestData = Session::get('cart_request_data') ? Session::get('cart_request_data')  : [] ;
        $user = Auth::user();
        $orderFor = isset($requestData['orderFor']) ? $requestData['orderFor'] : '';
        $agentRole = [2, 3, 4, 5, 6];

        $cart = Cart::wherehas('productdetails', function ($query) {
                            $query->where('is_deleted', '0')
                            ->where('status', "active");
                        })->with('variation')
                        ->where('user_id', $user->id)
                        ->where('status', "active")
                        ->get()
                        ->map(function($item){
                            $item->variation_value = $item->variation;
                            unset($item->variation);
                            return $item;
                        })->groupBy('seller_id');

        if (count($cart) != 0) {
            $amount = 0;
            $cartitem = [];
            $sellerIDs = [];
            foreach ($cart as $key => $item) {
                $sellerIDs[] = Helper::encrypt($key);
                $totalitems = 0;
                $seller = Seller::find($key);
                $sellertotal = 0;
                $result = [];
                $result['seller_id'] = ($seller) ? $seller->id : '';
                $result['seller_name'] = ($seller) ? $seller->name : '';
                foreach($item as $cart_item){
                    $product        = $cart_item->productdetails;
                    $cart_item->productdetails->image = $cart_item->productdetails->image();
                    $product_amount = $cart_item->getproductprice($user, $product->id, $cart_item->qty,$cart_item->variation_id);
                    $product_amount = $product_amount * $cart_item->qty;
                    $amount         += $product_amount;
                    $sellertotal    += $product_amount;
                    $local = 'en';
                    $cart_item->productdetails->name  = $product->printproductname($local, $product->id);

                    $cart_item->productdetails->customer_price  = $product->getcustomerproductprice($user, $product->id, $cart_item->qty,$cart_item->variation_id);
                    $customer_total     = $cart_item->productdetails->customer_price * $cart_item->qty;
                    $product            = Product::find($cart_item->product_id);
                    $cart_item->productdetails->cod = ($product->cod) ? 1 : 0;
                    $cart_item->cod     = ($product->cod) ? 1 : 0;
                    $result['products'][] = $cart_item;
                    $productIds[] = $product->id;
                    $productDataArray[$product->id]['product_id'] = $product->id;
                    $productDataArray[$product->id]['qty'] = $cart_item->qty;

                    $totalitems += $cart_item->qty;
                }
                $result['seller_total'] = $sellertotal;
                $result['totalitems'] = $totalitems;
               
                if(Auth::user()->role_id == '15'){
                    if($orderFor == 'customer'){
                        $defaultaddress = ($user->defaultStaffCustomerAddress != '' && $user->defaultStaffCustomerAddress != null) ? $user->defaultStaffCustomerAddress : $user->staffCustomerReceivers()->first();
                        $current_address = ($user->currentStaffCustomerAddress && $user->currentStaffCustomerAddress->count() > 0) ? $user->currentStaffCustomerAddress->first() : $defaultaddress;
                    }else{
                        $defaultaddress = ($user->defaultStaffAddress != '' && $user->defaultStaffAddress != null) ? $user->defaultStaffAddress : $user->staffReceivers()->first();
                        $current_address = ($user->currentStaffAddress && $user->currentStaffAddress->count() > 0) ? $user->currentStaffAddress->first() : $defaultaddress;
                    }
                }else if( in_array(Auth::user()->role_id , $agentRole) ){
                    if($orderFor == 'customer'){
                        $defaultaddress = ($user->defaultAgentCustomerAddress != '' && $user->defaultAgentCustomerAddress != null) ? $user->defaultAgentCustomerAddress : $user->agentCustomerReceivers()->first();
                        $current_address = ($user->currentAgentCustomerAddress && $user->currentAgentCustomerAddress->count() > 0) ? $user->currentAgentCustomerAddress->first() : $defaultaddress;
                    }else{
                        $defaultaddress = ($user->defaultAgentAddress != '' && $user->defaultAgentAddress != null) ? $user->defaultAgentAddress : $user->agentReceivers()->first();
                        $current_address = ($user->currentAgentAddress && $user->currentAgentAddress->count() > 0) ? $user->currentAgentAddress->first() : $defaultaddress;
                    }
                }else{
                    $defaultaddress = ($user->defaultaddress) ? $user->defaultaddress : $user->address()->first();
                    $current_address = ($user->current_address->count() > 0) ? $user->current_address->first() : $defaultaddress;
                }

                $shipping_companies = Helper::getShippingCompanies($result,$current_address);
                // dd(Helper::getShippingCompanies($result,$current_address));
                if(is_string($shipping_companies) || !is_a($shipping_companies['shipping_companies'], 'Illuminate\Database\Eloquent\Collection') || $shipping_companies['shipping_companies']->count() == 0){
                    return response()->json([
                        'success' => false, 'status' => 200, 'message' => 'Shipping not available in this state or address for '.$seller->name.' products']
                    );
                }
                return response()->json([
                    'success' => true, 'status' => 200, 'message' => 'Shipping method changed']
                );
            }
        }
    }
}
