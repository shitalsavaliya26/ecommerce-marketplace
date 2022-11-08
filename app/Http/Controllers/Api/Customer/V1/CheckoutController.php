<?php

namespace App\Http\Controllers\Api\Customer\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Response, Auth;
use App\VoucherProduct;
use App\OrderVoucher;
use App\Voucher;
use App\Helpers\Helper;
use App\Product;
use App\Cart;

class CheckoutController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /* get product voucher */
    public function getProductVoucher(Request $request){
        $validator = Validator::make(
            $request->all(),
            array(
                "products" => "required | array",
                "products.*" => "required|numeric|min:1",
            ),
            [
                'products.required' => trans('validation.required'),
                'products.*.required' => trans('validation.required')
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
        $user = $this->user;
        $vouchersofProducts = VoucherProduct::whereIn('product_id', $request->products)->get()->groupBy('voucher_id')->toArray();

        $voucherIds = [];
        $productVouchers = [];
        if (count($vouchersofProducts) > 0) {
            $voucherIds = array_keys($vouchersofProducts);
            $productVouchers = Voucher::with('products:id,voucher_id,product_id')
                                        ->whereIn('id', $voucherIds)
                                        ->where('usage_qty', '>', 0)->where('type', 'product')->whereDate('to_date', '>', now())
                                        ->get()
                                        ->filter(function ($product, $key) use ($user){
                                            $voucher = OrderVoucher::where('voucher_id',$product->id)->whereHas('order',function($query) use ($user){
                                                $query->where('user_id',$user->id);
                                            })->pluck('voucher_id')->toArray();
                                            return (!in_array($product->id, $voucher));
                                        })->values();
            return response()->json(['success' => true, 'data' => $productVouchers, 'message' => 'Data retrived successfully.', 'code' => 200], 200);
                            
        }

        return response()->json(['success' => false, 'data' => $productVouchers, 'message' => 'Data retrived successfully.', 'code' => 200], 200);

    }

    /* use voucher */
    public function useProductVoucher(Request $request){
        $user = auth()->user();
        $validator = Validator::make(
            $request->all(),
            array(
                // "cart_value" => "required",
                "products" => "required",
                "voucher_id" => "required",
            ),
            [
                // 'cart_value.required' => trans('messages.cartvaluerequired'),
                'products.required' => trans('validation.required'),
                'voucher_id.required' => trans('messages.couponidrequired'),
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

        $coupon     = [];
        $couponId   = $request->voucher_id;
        $products   = $request->products;
        $product_ids = $products;  
        $voucherData = Helper::getVoucherData($couponId, $cart_value, $product_ids);
        $product_name   = $voucherData['product'];
        $productID      = $voucherData['productID'];
        $discountType   = $voucherData['discountType'];
    
        $productData    = Product::find($productID);
        $sellerOfProduct = '';
        if($productData){
            $sellerOfProduct = $productData->seller_id;
        }
        $qtyOfProduct   = Cart::where('user_id',$user->id)->where('product_id',$productID)->first()->qty;
        $coupon     = Voucher::where('id', (int) $couponId)->where('min_basket_price', '<=', $cart_value)->first();

        $discountWithQty = $voucherData['discount'] * $qtyOfProduct;
        $cashbackWithQty = $voucherData['cashback'] * $qtyOfProduct;
        
        if($discountType == 'by_percentage'){
            $discount = $discountWithQty;
            $cashback = $cashbackWithQty;
        }

        if($discountType == 'cash'){
            $discount = ($discountWithQty > $coupon->discount_price) ? $coupon->discount_price : $discountWithQty;
            $cashback = ($cashbackWithQty > $coupon->discount_price) ? $coupon->discount_price : $cashbackWithQty;
        }
        if($coupon && $coupon->max_discount_price_type == 'limit'){
            $discount = ($discount > $coupon->max_discount_price) ? $coupon->max_discount_price: $discount;
            $cashback = ($cashback > $coupon->max_discount_price) ? $coupon->max_discount_price: $cashback;
        }

        if($coupon && $discount > 0){            
            return response::json(['success' => true, 'discount' => $discount, 'coupon' => $coupon, 'product_name' => $product_name, "code" => 200], 200);
        }
        if($coupon && $cashback > 0){            
            return response::json(['success' => true, 'cashback' => $cashback, 'coupon' => $coupon, 'product_name' => $product_name, "code" => 200], 200);
        }
        return response::json(['success' => false, 'discount' => 0, "code" => 200, 'message' => "The cart amount doesn't match the minimum spend of this coupon."], 200);
    }

     /* get seller voucher */
    public function getSellerVoucher(Request $request){
        $validator = Validator::make(
            $request->all(),
            array(
                "seller_id" => "required",
            ),
            [
                'seller_id.required' => trans('validation.required'),
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
        $sellerVouchers = Voucher::where('seller_id', $request->seller_id)
                                        ->where('usage_qty', '>', 0)
                                        ->where('type', 'seller')
                                        ->whereDate('to_date', '>', now())
                                        ->get();

        return response()->json(['success' => true, 'data' => $sellerVouchers, 'message' => 'Data retrived successfully.', 'code' => 200], 200);

    }

    /* use seller voucher */
    public function useSellerVoucher(Request $request){
        $sellerId = $request->seller_id;
        $voucherId = $request->voucher_id;
        $subTotal = $this->cartTotal();
        $voucher = Voucher::where('seller_id', $sellerId)->where('id', $voucherId)->first();
        $sellervoucher = false;

        if($voucher){
            $voucherData = Helper::getSellerVoucherDiscount($voucherId, $subTotal);

            $discount = $voucherData['discount'];
            $cashback = $voucherData['cashback'];
            $coupon = Voucher::where('id', $voucherId)->first();

            if($coupon && $discount > 0){            
                return response::json(['success' => true, 'discount' => $discount, 'coupon' => $coupon, 'seller_id' => $sellerId, "code" => 200], 200);
            }
            if($coupon && $cashback > 0){            
                return response::json(['success' => true, 'cashback' => $cashback, 'coupon' => $coupon, 'seller_id' => $sellerId, "code" => 200], 200);
            }
            return response::json(['success' => false, 'discount' => 0, "code" => 200], 200);
        }
        return response::json(['success' => false, 'message' => "No voucher found", "code" => 400], 400);

    }

    public function cartTotal(){
        $user = $this->user;
        $cart = Cart::wherehas('productdetails', function ($query) {
                            $query->where('is_deleted', '0')
                            ->where('status', "active");
                        })->with('variation')
                        ->with(['product'=>function($query){
                            $query->with('attributevariationprice')->with('variation')->with('image');
                        }])
                        ->where('user_id', $user->id)
                        ->get();
        $subtotal = 0;
        foreach ($cart as $cart_item) {
            $product = $cart_item->productdetails;

            $product_amount = $cart_item->getproductprice($user, $product->id, $cart_item->qty, $cart_item->variation_id);
            $product_amount = $product_amount * $cart_item->qty;
            $subtotal = $subtotal + $product_amount;
        }
        return $subtotal;
    }
}
