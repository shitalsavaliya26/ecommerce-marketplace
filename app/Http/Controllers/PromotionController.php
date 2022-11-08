<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserVoucher;
use App\Voucher;
use App\Promotion;
use App\Cart;
use App\Product;
use App\Seller;
use Validator,Auth,Response;
use App\Helpers\Helper;

class PromotionController extends Controller
{
    public function view($slug){
        $promotion = Promotion::where('slug',$slug)->first();
        if(!$promotion){
            abort(404);
        }
        $contents  = $promotion->contents()->orderBy('order','asc')->get();
        
        return view('frontend.promotion',compact('promotion','contents'));
    }

    /* claim voucher */
    public function claimvoucher(Request $request){
        $user = Auth::user();
        $validator = Validator::make(
            $request->all(),
            array(
                "coupon_id" => "required",
            ),
            [
                'coupon_id.required' => 'Something went wrong! Please try latter!',
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

        $voucherId = Helper::decrypt($request->coupon_id);
        $promotion = Promotion::where('slug',$request->promotion)->first();

        UserVoucher::updateOrCreate(['user_id' => $user->id, 'voucher_id' => $voucherId, 'promotion_id' => $promotion->id]);
        return response::json(['success' => true, 'message' => 'Vocher claimed successfully', "code" => 200], 200);

    }

    public function redeemvoucher(Request $request){
        $user = Auth::user();
        $in_cart = Cart::where('user_id', $user->id)->get();
        if($in_cart->count() == 0){
            return response::json(['success' => false, 'message' => "No product found in your cart!"]);
        }
        $validator = Validator::make(
            $request->all(),
            array(
                "coupon_id" => "required",
            ),
            [
                'coupon_id.required' => 'Something went wrong! Please try latter!',
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
        $amount = 0;
        $sellers = [];
        foreach ($in_cart as $cart_item) {
            $product = Product::where('id', $cart_item->product_id)->first();
            $product_amount = $cart_item->getproductprice($user, $cart_item->product_id, $cart_item->qty, $cart_item->variation_id);
            $product_amount = $product_amount * $cart_item->qty;
            $amount = $amount + $product_amount;
            if(isset($sellers[$product->seller_id])){
                $sellers[$product->seller_id] += $product_amount;
            }else{

                $sellers[$product->seller_id] = $product_amount;
            }
               
        }

        $voucherId = Helper::decrypt($request->coupon_id);
        $product_array = $in_cart->pluck('product_id')->toArray();

        $voucherData = Helper::getVoucherData($voucherId, null, $product_array);
        $voucherType = Helper::getVoucherType($voucherId);

        $discount = $voucherData['discount'];
        $cashback = $voucherData['cashback'];
        $product_name = $voucherData['product'];
        $pid = $voucherData['productID'];

        $coupon = Voucher::where('id', (int) $voucherId)->where('min_basket_price', '<=', $amount)->first();
        if($coupon && $discount > 0){     
            session()->put('promotion', ['promotion' => $request->promotion, 'type' => 'product','product_name' => $product_name , 'voucher_id' => $request->coupon_id]);       
            return response::json(['success' => true, 'product_name' => Helper::encrypt($voucherId),"code" => 200], 200);
        }
        if($coupon && $cashback > 0){    
            session()->put('promotion', ['promotion' => $request->promotion, 'type' => 'product', 'product_name' => $product_name, 'voucher_id' => $request->coupon_id]);       

            return response::json(['success' => true, 'product_name' => Helper::encrypt($voucherId),"code" => 200], 200);
        }
        if($voucherType == 'product' && $discount <= 0 && $cashback <= 0){    
            session()->put('promotion', ['promotion' => $request->promotion, 'type' => 'product', 'product_name' => $product_name, 'voucher_id' => $request->coupon_id]);       
            return response::json(['success' => false, 'message' => 'Voucher not valid for products that you have selected','discount' => 0, "code" => 200], 200);
        }

        $sellerIds = array_keys($sellers);
        $couponSellerId = $coupon->seller_id;

        $sendSellerVoucherData = '';
        if($sellers && isset($sellers[$couponSellerId])){
            $sendSellerVoucherData = ($sellers[$couponSellerId]);
        }

        if( !in_array($couponSellerId,$sellerIds ) ){
            return response::json(['success' => false, 'message' => 'Voucher not valid for products that you have selected','discount' => 0, "code" => 200], 200);
        }else{
            $sellerobj = Seller::with(['vouchers' => function($q) use($sendSellerVoucherData) {
                $q->where('min_basket_price', '<=', $sendSellerVoucherData);
            }])->find($coupon->seller_id);                              
            if($sellerobj && $sellerobj->vouchers && count($sellerobj->vouchers) > 0){
                $voucherData = Helper::getSellerVoucherDiscount($voucherId, $sendSellerVoucherData);
                $discount = $voucherData['discount'];
                $cashback = $voucherData['cashback'];
                $coupon = Voucher::where('id', $voucherId)->first();

                if($coupon && $discount > 0){         
                    session()->put('promotion', ['promotion' => $request->promotion, 'type' => 'seller', 'voucher_id' => $request->coupon_id, 'seller_id' => $coupon->seller_id, 'total' => $sendSellerVoucherData]);       
                    return response::json(['success' => true, 'discount' => $discount, 'coupon' => $coupon, 'seller_id' => $coupon->seller_id,'product_name' => 'seller', "code" => 200], 200);
                }
                if($coupon && $cashback > 0){     
                    session()->put('promotion', ['promotion' => $request->promotion, 'type' => 'seller', 'voucher_id' => $request->coupon_id, 'seller_id' => $coupon->seller_id, 'total' => $sendSellerVoucherData]);              
                    return response::json(['success' => true, 'cashback' => $cashback, 'coupon' => $coupon, 'seller_id' => $coupon->seller_id,'product_name' => 'seller', "code" => 200], 200);
                }
            }
        }
        return response::json(['success' => false, 'message' => 'Voucher not valid for products that you have selected','discount' => 0, "code" => 200], 200);
    }
}
