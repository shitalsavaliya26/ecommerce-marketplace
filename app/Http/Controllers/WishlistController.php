<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Response,Auth;
use App\Wishlist;
use App\Helpers\Helper;
use App\Cart;

use App\Product;

use App\AttributeVariationPrice;

class WishlistController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();
        $mylist = Wishlist::wherehas('productdetails', function ($query) {
                                    $query->where('is_deleted', '0')
                                    ->where('status', "active");
                                })->with('variation')
                                ->where('user_id', $user->id)
                                ->get()
                                ->map(function($item){
                                    $item->variation_value = $item->variation;
                                    unset($item->variation);
                                    return $item;
                                });
                                // dd($mylist);
        $locale = app()->getLocale();
        if (count($mylist) > 0) {
            foreach ($mylist as $list) {
                $list->productdetails->image = $list->productdetails->image();
                $list->productdetails->in_stock = true;

                if ($list->productdetails->qty <= 0) {
                    $list->productdetails->in_stock = false;
                }
                $list->name = $list->productdetails->printproductname($locale, $list->product_id);
                $list->description = $list->productdetails->printproductdescription($locale, $list->product_id);
            }
        } 
        return view('frontend.wishlist',compact('mylist'));
    }

    public function wishlistaddremove(Request $request)
    {   
        $user = Auth::user();
        $validator = Validator::make(
                            $request->all(),
                            array(
                                "slug" => "required",
                                // "variation_id" => "required",
                            ),
                            [
                                'slug.required' => 'Product id is required',
                            ]
                        );
        if ($validator->fails()) {
            $msg = $validator->errors()->getMessages();
            $ms = "Validation error";
            foreach ($msg as $key => $value) {
                $ms = $value[0];
            }
            return response::json(['success' => false, 'message' => $ms, "code" => 400], 400);
        } else {
            $product_id = Helper::decrypt($request->slug);
            $is_exits = Wishlist::where('user_id', $user->id)
                            ->where('product_id', $product_id);

            if($request->has('variation_id') && $request->variation_id != ''){
                $variation_id = Helper::decrypt($request->variation_id);
                $is_exits = $is_exits->where('variation_id', $variation_id);    
            }

            $is_exits = $is_exits->count();

            if ($is_exits > 0) {
                $wishlist = Wishlist::where('user_id', $user->id)
                                    ->where('product_id', $product_id);

                if($request->has('variation_id') && $request->variation_id != ''){
                    $variation_id = Helper::decrypt($request->variation_id);
                    $wishlist = $wishlist->where('variation_id', $variation_id);    
                }

                $wishlist = $wishlist->delete();

                return Response::json(["success" => true, "message" => trans('messages.wishlistremove'), "code" => 200], 200);
            } else {
                $wishlist               = new Wishlist();
                $wishlist->product_id   = $product_id;
                if($request->has('variation_id') && $request->variation_id != ''){
                    $variation_id = Helper::decrypt($request->variation_id);
                    $wishlist->variation_id = $variation_id;
                }
                $wishlist->user_id      = $user->id;
                $wishlist->save();

                return Response::json(["success" => true, "message" => trans('messages.wishlistadd'), "code" => 200], 200);
            }
        }
    }

    public function moveToCart(Request $request)
    {   
        $user = Auth::user();
        $qty = true;
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
                    \Session::flash('success', trans('messages.itenaddtocart'));
                } else {
                    $in_cart->qty = $in_cart->qty + 1;
                    $in_cart->save();
                    \Session::flash('success', trans('messages.updateditemcart'));
                }
                $product->delete();
                return redirect()->back();
            }
            \Session::flash('error', trans('messages.requestqtynotavailable'));

            return redirect()->back();
         }

    }

    
}
