<?php

namespace App\Http\Controllers\Api\Customer\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth,Validator,Response;
use App\Wishlist;
use App\Helpers\Helper;
use App\Cart;
use App\Product;
use App\AttributeVariationPrice;
use App\Seller;

class WishlistController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /* move to wishlist common function */
    public function wishlistaddremove(Request $request)
    {   
        $user = Auth::user();
        $validator = Validator::make(
                            $request->all(),
                            array(
                                "product_id" => "required",
                            ),
                            [
                                'product_id.required' => 'Product id is required',
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
        $product_id = $request->product_id;
        $is_exits = Wishlist::where('user_id', $user->id)
                            ->where('product_id', $product_id);

        if($request->has('variation_id') && $request->variation_id != ''){
            $variation_id = $request->variation_id;
            $is_exits = $is_exits->where('variation_id', $variation_id);    
        }

        $is_exits = $is_exits->count();
        if ($is_exits > 0) {
            $wishlist = Wishlist::where('user_id', $user->id)
                                ->where('product_id', $product_id);

            if($request->has('variation_id') && $request->variation_id != ''){
                $variation_id = $request->variation_id;
                $wishlist = $wishlist->where('variation_id', $variation_id);    
            }

            $wishlist = $wishlist->delete();

            return Response::json(["success" => true, "message" => trans('messages.wishlistremove'), "code" => 200], 200);
        }
        $wishlist               = new Wishlist();
        $wishlist->product_id   = $product_id;
        if($request->has('variation_id') && $request->variation_id != ''){
            $variation_id = $request->variation_id;
            $wishlist->variation_id = $variation_id;
        }
        $wishlist->user_id      = $user->id;
        $wishlist->save();
        return Response::json(["success" => true, "message" => trans('messages.wishlistadd'), "code" => 200], 200);
    }

    /* get wishlist */
    public function getWishlist()
    {
        $user   = $this->user;
        $mylist = Wishlist::wherehas('productdetails', function ($query) {
                                    $query->where('is_deleted', '0')
                                    ->where('status', "active");
                                })->with('variation')
                                ->with(['productdetails'=>function($query){
                                        $query->with('image');
                                    }])
                                ->where('user_id', $user->id)
                                ->get()
                                ->map(function($item){
                                    $item->variation_value = $item->variation;
                                    unset($item->variation);
                                    return $item;
                                })->groupBy('productdetails.seller_id');
                                // dd($mylist->toArray());
                                
        $locale = app()->getLocale();
        $data = [];

        if (count($mylist) > 0) {
            foreach ($mylist as $key => $item) {
                $seller = Seller::find($key);
                $result = [];
                $result['seller_id'] = ($seller) ? $seller->id : '';
                $result['seller_name'] = ($seller) ? $seller->name : '';
                foreach ($item as $list) {
                    $list->productdetails->image = $list->productdetails->image();
                    $list->productdetails->in_stock = true;

                    if ($list->productdetails->qty <= 0) {
                        $list->productdetails->in_stock = false;
                    }
                    $list->name = $list->productdetails->printproductname($locale, $list->product_id);
                    $list->description = $list->productdetails->printproductdescription($locale, $list->product_id);
                    $result['products'][] = $list;
                }
                $data[] = $result;
            }
        } 
        return response()->json(['success' => true, 'data' => $data, 'message' => 'Data retrived successfully.', 'code' => 200], 200);
    }

    /* move to cart */
    public function moveToCart(Request $request)
    {   
        $user = Auth::user();
        $qty = true;
        if($request->has('product_id')){
            $wishlist = Wishlist::where('user_id', $user->id)
                                    ->where('product_id', $request->product_id)
                                    ->whereHas('productdetails')
                                    ->first();
            $productactual = Product::where('id', $request->product_id)->first();
            if($request->variation_id > 0){
                $variation = AttributeVariationPrice::find($request->variation_id);
                if($variation->qty == 0){
                    $qty = false;
                }
            }else{
                if($productactual->qty == 0){
                    $qty = false;
                }
            }
            if($qty){
                $in_cart = Cart::where('product_id', $productactual->id)
                                ->where('user_id', $user->id);
                if($request->variation_id != '' && $request->variation_id != 0){
                    $in_cart = $in_cart->where('variation_id', $request->variation_id);    
                }

                $in_cart = $in_cart->first();
                if (empty($in_cart)) {
                    $data = [
                        'user_id' => $user->id,
                        'product_id' => $productactual->id,
                        'qty' => 1,
                        'seller_id' => $productactual->seller_id,
                    ];
                    if($request->variation_id != '' && $request->variation_id != 0){
                        $data['variation_id'] = $request->variation_id;
                    }
                    $cart = Cart::create($data);
                    $message = trans('messages.itenaddtocart');
                } else {
                    $in_cart->qty = $in_cart->qty + 1;
                    $in_cart->save();
                    $message = trans('messages.updateditemcart');
                }
                $wishlist->delete();
                return response::json(['success' => true, 'message' => $message, "code" => 200], 200);
            }
            return response::json(['success' => false, 'message' => trans('messages.requestqtynotavailable'), "code" => 400], 400);

        }
        $wishlist = Wishlist::where('user_id', $user->id)->whereHas('productdetails')->get();
        foreach($wishlist as $product){
            $productactual = Product::where('id', $product->product_id)->first();
            if($product->variation_id > 0){
                $variation = AttributeVariationPrice::find($product->variation_id);
                if($variation->qty == 0){
                    $qty = false;
                }
            }else{
                if($productactual->qty == 0){
                    $qty = false;
                }
            }
            if($qty){
                 $in_cart = Cart::where('product_id', $productactual->id)
                                ->where('user_id', $user->id);
                if($product->variation_id != '' && $product->variation_id != 0){
                    $in_cart = $in_cart->where('variation_id', $product->variation_id);    
                }

                $in_cart = $in_cart->first();
                if (empty($in_cart)) {
                    $data = [
                        'user_id' => $user->id,
                        'product_id' => $productactual->id,
                        'qty' => 1,
                        'seller_id' => $productactual->seller_id,
                    ];
                    if($product->variation_id != '' && $product->variation_id != 0){
                        $data['variation_id'] = $product->variation_id;
                    }
                    $cart = Cart::create($data);
                    $message = trans('messages.itenaddtocart');
                } else {
                    $in_cart->qty = $in_cart->qty + 1;
                    $in_cart->save();
                    $message = trans('messages.updateditemcart');
                }
                $product->delete();
                return response::json(['success' => true, 'message' => $message, "code" => 200], 200);

            }
            return response::json(['success' => false, 'message' => trans('messages.requestqtynotavailable'), "code" => 400], 400);

        }

    }
}
