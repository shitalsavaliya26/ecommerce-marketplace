<?php

namespace App\Http\Controllers\Api\Customer\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Customer\V1\WishlistController;
use App\Http\Controllers\Controller;
use App\Helpers\NotificationHelper;
use App\AttributeVariationPrice;
use App\PushNotification;
use App\VoucherProduct;
use App\CoinManagement;
use App\Helpers\Helper;
use App\BundleDeal;
use Carbon\Carbon;
use Notification;
use App\Voucher;
use App\Product;
use App\Seller;
use App\Cart;
use Validator;
use Response;
use Auth;

class CartController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /* add to cart */
    public function addtocart(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                "product_id" => "required",
                "qty" => "required|numeric|min:1",
            ),
            [
                'product_id.required' => trans('messages.productidreq'),
                'qty.required' => trans('messages.qtyreq'),
                'qty.min:1' => trans('messages.qtymin1'),
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
        $product = Product::where('id', $request->product_id)->first();
        $variation_id = $request->variation_id;
        $variation = '';

        $in_cart = Cart::where('product_id', $request->product_id)
                        ->where('user_id', $this->user->id);
        if($request->has('variation_id') && $request->variation_id != ''){
            $in_cart = $in_cart->where('variation_id', $request->variation_id);    
        }
        $in_cart = $in_cart->first();

        if ($request->has('variation_id')) {
            $variation = $variation_id = AttributeVariationPrice::where('product_id', $request->product_id)
                                            ->where('id',$request->variation_id)
                                            ->get();
            $variation_id = $variation_id[0]->id;
        }

        if (($variation_id == '' && $product->qty < $request->qty) || ($variation_id != '' && $variation[0]->qty < $request->qty) || $product->is_deleted == 1) {
            return Response::json(["success" => false, "message" => trans('messages.requestqtynotavailable'), "code" => 400], 400);
        }

        $product_id = $request->product_id;
        $is_product = Product::where('is_deleted', "0")->where('status', "active");
        if($request->has('variation_id') && $request->variation_id != ''){
            $is_product = $is_product->whereHas('attributevariationprice',function($query) use ($request)
                {
                    $query->where('id', $request->variation_id);
                });    
        }

        $is_product = $is_product->where('id', $product_id)->first();
        if (!$is_product) {
            return Response::json(["success" => true, "message" => trans('messages.productnotfound'), "code" => 500], 500);
        }

        $in_cart = Cart::where('product_id', $product_id)
                    ->where('user_id', $this->user->id);

        if ($variation_id != '') {
            $in_cart = $in_cart->where('variation_id', $variation_id);
        }

        $in_cart = $in_cart->first();
        if (empty($in_cart)) {
            $data = [
                'user_id' => $this->user->id,
                'product_id' => $product_id,
                'qty' => $request->qty,
                'seller_id' => $is_product->seller_id,
            ];
            if ($variation_id != '') {
                $data['variation_id'] = $variation_id;
            }
            $cart = Cart::create($data);
            if ($request->has('buy')) {
                return redirect()->route('viewcart');
            }
            return Response::json(["success" => true, "message" => trans('messages.itenaddtocart'), "code" => 200], 200);
        } 

        $in_cart->qty = $in_cart->qty + $request->qty;
        $in_cart->save();
        return Response::json(["success" => true, "message" => trans('messages.updateditemcart'), "code" => 200], 200);
    }

    /* view cart */
    public function viewcart(Request $request)
    {
        $user = $this->user;
        $cart = Cart::wherehas('productdetails', function ($query) {
                            $query->where('is_deleted', '0')
                            ->where('status', "active");
                        })->with('variation')
                        ->with(['product'=>function($query){
                            $query->with('attributevariationprice')->with('variation')->with('image');
                        }])
                        ->where('user_id', $user->id)
                        ->get()
                        ->map(function ($item) {
                            $item->variation_value = $item->variation;
                            unset($item->variation);
                            return $item;
                        })->groupBy('seller_id');

        $product = null;
        $amount = 0;
        $customer_amount = 0;
        $cartitem = [];
        $totalitems = 0;
        foreach ($cart as $key => $item) {
            $seller = Seller::find($key);
            $result = [];
            $result['seller_id'] = ($seller) ? $seller->id : '';
            $result['seller_name'] = ($seller) ? $seller->name : '';
            foreach ($item as $cart_item) {

                $product = $cart_item->productdetails;
                $cart_item->productdetails->image = $cart_item->productdetails->image();
                $product_amount = $cart_item->getproductprice($user, $product->id, $cart_item->qty, $cart_item->variation_id);
                $product_amount = $product_amount * $cart_item->qty;
                $amount = $amount + $product_amount;
                $local = 'en';
                $cart_item->productdetails->name = $product->printproductname($local, $product->id);

                $cart_item->productdetails->customer_price = $product->getcustomerproductprice($user, $product->id, $cart_item->qty, $cart_item->variation_id);


                $customer_total = $cart_item->productdetails->customer_price * $cart_item->qty;
                $customer_amount = $customer_amount + $customer_total;
                $product = Product::find($cart_item->product_id);
                $cart_item->productdetails->cod = ($product->cod) ? 1 : 0;
                $cart_item->cod = ($product->cod) ? 1 : 0;
                $result['products'][] = $cart_item;
                unset($cart_item->productdetails);
                $totalitems++;
            }
            $cartitem[] = $result;
        }
        $data['cart'] = $cartitem;
        $data['totalitems'] = $totalitems;
        $data['subtotal'] = $customer_amount;

        $cartProductIds = Cart::pluck('product_id')->toArray();
        $vouchersofProducts = VoucherProduct::whereIn('product_id', $cartProductIds)->get()->groupBy('voucher_id')->toArray();

        $voucherIds = [];
        $productVouchers = [];
        if (count($vouchersofProducts) > 0) {
            $voucherIds = array_keys($vouchersofProducts);
            $productVouchers = Voucher::with('products:id,voucher_id,product_id')->whereIn('id', $voucherIds)
            ->where('usage_qty', '>', 0)->where('type', 'product')->whereDate('to_date', '>', now())->get();
        }
        $data['product_vouchers'] = $productVouchers;

        return response()->json(['success' => true, 'data' => $data, 'message' => 'Data retrived successfully.', 'code' => 200], 200);

    }

    /* update cart */
    public function updatecart(Request $request)
    {
        $user = $this->user;

        $validator = Validator::make(
            $request->all(),
            array(
                "cart_id" => "required",
                "product_id" => "required",
                "qty" => "required",
            ),
            [
                'cart_id.required' => trans('messages.cart_id.required'),
                'product_id.required' => trans('messages.product_id.required'),
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
        $cart = Cart::where('id', $request->cart_id)->where('product_id', $request->product_id)->first();
        if ($cart->qty < $request->qty) {
            $product = Product::where('id', $request->product_id)->first();
            if (($product->qty < $request->qty && $cart->variation_id == 0) || $product->is_deleted == 1) {
                return Response::json(["success" => false, "message" => trans('messages.requestqtynotavailable'), "code" => 400], 400);
            }
            if($cart->variation_id > 0){
                $product = AttributeVariationPrice::find($cart->variation_id);
                if($product->qty < $request->qty){
                    return Response::json(["success" => false, "message" => trans('messages.requestqtynotavailable'), "code" => 400], 400);
                }
            }

        }

        if (!empty($cart)) {
            $cart->qty = $request->qty;
            $cart->save();
        }
        return response::json(['success' => true, 'message' => trans('messages.qtyupdate'), "code" => 200], 200);
    }

    /* delete cart */
    public function deletecartproduct(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                "cart_id" => "required|array",
                "cart_id.*" => "required|exists:carts,id"
            ),
            [
                'cart_id.required' => trans('messages.cartidreq'),
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
        $cart_array = $request->cart_id;
        for ($i = 0; $i < count($cart_array); $i++) {
            $cart = Cart::where('id', $cart_array[$i])->where('user_id', $user->id)->first();
            if (!empty($cart)) {
                $cart->delete();
            }
        }

        return response::json(['success' => true, 'message' => trans('messages.carttemdelete'), "code" => 200], 200);
    }

    /* move to wishlist */
    public function moveToWishlist(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                "cart_id" => "required|array",
            ),
            [
                'cart_id.required' => trans('messages.cartidreq'),
            ]
        );

        if ($validator->fails()) {
            $msg = $validator->errors()->getMessages();
            $ms = "Validation error";
            foreach ($msg as $key => $value) {
                $ms = $value[0];
            }
            return response::json(['success' => false, 'message' => $ms, "code" => 200], 200);
        }

        $user = $this->user;
        $cart_array = $request->cart_id; //($request->has('type') && $request->type == 'multiple') ? $request->cary_id : explode(",", $request->cary_id);
        for ($i = 0; $i < count($cart_array); $i++) {
            $cart = Cart::where('id', $cart_array[$i])->where('user_id', $user->id)->first();
            if (!empty($cart)) {
                $cart->delete();
                $myRequest = new Request();
                $myRequest->setMethod('POST');
                $myRequest->request->add(['product_id' => $cart->product_id]);
                $myRequest->request->add(['variation_id' => ($cart->variation_id != '') ? $cart->variation_id : null]);

                $wishlist = new WishlistController();
                $wishlist->wishlistaddremove($myRequest);
            }
        }
        return response::json(['success' => true, 'message' => trans('messages.carttemdelete'), "code" => 200], 200);
    }
}
