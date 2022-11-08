<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\WishlistController;
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
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
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
            \Session::flash('error', $ms);
            return redirect()->back();
        }
        $product_id = Helper::decrypt($request->product_id);
        $variation_id = '';
        $variation = '';
        if ($request->has('variation')) {
            $variation_ids = array_values($request->variation);
            $variation = $variation_id = AttributeVariationPrice::where('product_id', $product_id)
            // ->where('variation_value',$request->product_variation_id)
                ->get()
                ->filter(function ($variation, $key) use ($variation_ids) {
                    return !array_diff($variation->variation_value, $variation_ids);
                })->values();
            $variation_id = $variation_id[0]->id;
        }
        if (Auth::check()) {

            $user = Auth::user();
            $product = Product::where('id', $product_id)->first();
            $in_cart = Cart::where('product_id', $product_id)
                ->where('user_id', $user->id);
            if ($variation_id != '') {
                $in_cart = $in_cart->where('variation_id', $variation_id);
            }
            $in_cart = $in_cart->first();
            if (($variation_id == '' && $product->qty < $request->qty) || ($variation_id != '' && $variation[0]->qty < $request->qty) || $product->is_deleted == 1) {
                \Session::flash('error', trans('messages.requestqtynotavailable'));
                return redirect()->back();
            }

            $is_product = Product::where('is_deleted', "0")->where('status', "active");
            if ($variation_id != '') {
                $is_product = $is_product->whereHas('attributevariationprice', function ($query) use ($variation_id) {
                    $query->where('id', $variation_id);
                });
            }
            $is_product = $is_product->where('id', $product_id)->first();
            if (!$is_product) {
                \Session::flash('error', trans('messages.productnotfound'));
                return redirect()->back();
            } else {
                $in_cart = Cart::where('product_id', $product_id)
                    ->where('user_id', $user->id);
                if ($variation_id != '') {
                    $in_cart = $in_cart->where('variation_id', $variation_id);
                }

                $in_cart = $in_cart->first();
                if (empty($in_cart)) {
                    $data = [
                        'user_id' => $user->id,
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
                    \Session::flash('success', trans('messages.itenaddtocart'));
                    return redirect()->back();
                } else {
                    $in_cart->qty = $in_cart->qty + $request->qty;
                    $in_cart->save();
                    if ($request->has('buy')) {
                        return redirect()->route('viewcart');
                    }
                    \Session::flash('success', trans('messages.updateditemcart'));
                    return redirect()->back();
                }
            }
        } else {
            $product = Product::where('id', $product_id)->first();

            $cart = session()->get('cartItems');
            if ($variation_id != '') {
                $product_id = $product_id . '_' . $variation_id;
            }
            // dd($cart);
            if (isset($cart[$product_id])) {
                $cart[$product_id]['qty']++;
            } else {
                $cart[$product_id] = [
                    "id" => uniqid(),
                    "product_id" => $product->id,
                    "qty" => 1,
                    "seller_id" => $product->seller_id,
                    "price" => $product->getcustomerproductprice(null, $product->id, $request->qty, $variation_id),
                    "variation_id" => $variation_id,
                ];

            }

            session()->put('cartItems', $cart);

            \Session::flash('success', trans('messages.itenaddtocart'));
            return redirect()->route('login');
        }
    }

    /* add to cart */
    public function addAllToCart(Request $request)
    {
        if ($request->has('productData') && count($request->productData) > 0) {
            foreach ($request->productData as $product) {
                $product_id = $product;
                $variation_id = '';
                $qty = 1;
                $checkVariation = Product::find($product_id);
                if ($checkVariation->is_variation == '1') {
                    $variation_id = AttributeVariationPrice::where('product_id', $product_id)
                        ->first();
                    $variation_id = $variation_id->id;
                }

                if (Auth::check()) {
                    $user = Auth::user();
                    $product = Product::where('id', $product_id)->first();
                    $in_cart = Cart::where('product_id', $product_id)
                        ->where('user_id', $user->id);
                    if ($variation_id != '') {
                        $in_cart = $in_cart->where('variation_id', $variation_id);
                    }
                    $in_cart = $in_cart->first();
                    $checkQty = ($product->is_variation == '1' && $product->variation) ? $product->variation->qty : $product->qty;
                    if ($checkQty < $qty || $product->is_deleted == 1) {
                        return response::json(['success' => false, 'message' => trans('messages.requestqtynotavailable'), "code" => 200], 200);
                    }

                    $is_product = Product::where('is_deleted', "0")->where('status', "active");
                    if ($variation_id != '') {
                        $is_product = $is_product->whereHas('attributevariationprice', function ($query) use ($variation_id) {
                            $query->where('id', $variation_id);
                        });
                    }
                    $is_product = $is_product->where('id', $product_id)->first();
                    if (!$is_product) {
                        return response::json(['success' => false, 'message' => trans('messages.productnotfound'), "code" => 200], 200);
                    } else {
                        $in_cart = Cart::where('product_id', $product_id)
                            ->where('user_id', $user->id);
                        if ($variation_id != '') {
                            $in_cart = $in_cart->where('variation_id', $variation_id);
                        }

                        $in_cart = $in_cart->first();
                        if (empty($in_cart)) {
                            $data = [
                                'user_id' => $user->id,
                                'product_id' => $product_id,
                                'qty' => $qty,
                                'seller_id' => $is_product->seller_id,
                                'bundle_deal_id' => (int) $request->dealId,
                            ];
                            if ($variation_id != '') {
                                $data['variation_id'] = $variation_id;
                            }
                            $cart = Cart::create($data);
                            if ($request->has('buy')) {
                                return redirect()->route('viewcart');
                            }
                        } else {
                            $in_cart->qty = $in_cart->qty + $qty;
                            $in_cart->bundle_deal_id = ($request->dealId && $request->dealId > 0) ? $request->dealId : $in_cart->bundle_deal_id;
                            $in_cart->save();
                            if ($request->has('buy')) {
                                return redirect()->route('viewcart');
                            }
                        }
                    }
                } else {
                    $product = Product::where('id', $product_id)->first();
                    $cart = session()->get('cartItems');
                    if ($variation_id != '') {
                        $product_id = $product_id . '_' . $variation_id;
                    }
                    if (isset($cart[$product_id])) {
                        $cart[$product_id]['qty']++;
                    } else {
                        $cart[$product_id] = [
                            "id" => uniqid(),
                            "product_id" => $product->id,
                            "qty" => 1,
                            "seller_id" => $product->seller_id,
                            "price" => $product->getcustomerproductprice(null, $product->id, $qty, $variation_id),
                            "variation_id" => $variation_id,
                            'bundle_deal_id' => $request->dealId,
                        ];

                    }
                    session()->put('cartItems', $cart);
                }
            }
            return response::json(['success' => true, 'message' => trans('messages.itenaddtocart'), "code" => 200], 200);
        }
    }

     /* view cart */
    public function viewcart(Request $request)
    {
        if (Auth::check()) {

            $user = Auth::user();
            $cart = Cart::wherehas('productdetails', function ($query) {
                $query->where('is_deleted', '0')
                    ->where('status', "active");
            })->with('variation')->with('product')
                ->where('user_id', $user->id)
                ->get()
                ->map(function ($item) {
                    $item->variation_value = $item->variation;
                    unset($item->variation);
                    return $item;
                })->groupBy('seller_id');

            $bundleAmount = 0;
            $bundleDiscount = 0;
            $cartData = Cart::select('id', 'bundle_deal_id', 'product_id', 'qty')->with('bundleDeal')->where('user_id', $user->id)->get();
            $cartProductIds = array_column($cartData->toArray(), 'product_id');
            $bundleId = $cartData->groupBy('bundle_deal_id')->toArray();
            $bundleId = key($bundleId);
            $bundleProductIds = [];
            if ($bundleId && $bundleId > 0) {
                $bundleDealProductData = BundleDeal::with('BundleDealProducts')->find($bundleId);
                if ($bundleDealProductData && $bundleDealProductData->BundleDealProducts && count($bundleDealProductData->BundleDealProducts) > 0) {
                    $bundleProducts = $bundleDealProductData->BundleDealProducts;
                    $bundleProductIds = $bundleProducts->pluck('product_id')->toArray();
                    foreach ($bundleProductIds as $bundleProductId) {
                        $product = Product::where('id', $bundleProductId)->first();
                        $variationId = $product->is_variation == '1' ? $product->variation->id : null;
                        $bundleAmount = $bundleAmount + $product->getcustomerproductprice($user, $bundleProductId, 1, $variationId);
                    }
                    $bundleDiscount = ($bundleAmount * $bundleDealProductData->discount) / 100;
                }
            }
            if ($bundleProductIds) {
                $cartContainBundleProduct = !array_diff($bundleProductIds, $cartProductIds);
            } else {
                $cartContainBundleProduct = false;
            }
            // return [$bundleProductIds];
                        $product = null;

            // if (1) {
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

                        $totalitems++;
                    }
                    $cartitem[] = $result;
                }
                $sub_total = 0; //$amount;
                $categories = ($product) ? $product->categories->pluck('category_id') : [];
                $sameSellerProducts = [];
                $categoryProducts = [];
                if($product){

                    $sameSellerProducts = Product::whereHas('categories')
                        ->where('seller_id', $product->seller_id)
                        ->inRandomOrder()
                        ->limit(4)->get();

                    if (count($categories) > 0) {
                        $categoryProducts = Product::whereHas('categories', function ($query) use ($categories) {
                            $query->where('category_id', $categories);
                        })->inRandomOrder()->limit(8)->get();
                    } else {
                        $categoryProducts = Product::where('name', 'like', '%' . $product->name . '%')->inRandomOrder()->limit(8)->get();
                    }
                }

                $usedvariations = $cart = Cart::wherehas('productdetails')
                    ->where('user_id', $user->id)->pluck('variation_id')->toArray();

                $vouchersofProducts = VoucherProduct::whereIn('product_id', $cartProductIds)->get()->groupBy('voucher_id')->toArray();

                $voucherIds = [];
                $productVouchers = [];
                if (count($vouchersofProducts) > 0) {
                    $voucherIds = array_keys($vouchersofProducts);
                    $productVouchers = Voucher::with('products:id,voucher_id,product_id')->whereIn('id', $voucherIds)
                                        ->where('usage_qty', '>', 0)->where('type', 'product')->whereDate('to_date', '>', now())->get();
                }
                // dd($cartitem);
                return view('frontend.cart', compact('cartitem', 'bundleId', 'bundleDiscount', 'cartContainBundleProduct', 'amount', 'sameSellerProducts', 'categoryProducts', 'sub_total', 'totalitems', 'usedvariations', 'productVouchers', 'cartProductIds'));
            // } else {
            //     \Session::flash('error', trans('messages.cartproduct'));
            //     return redirect()->route('home');
            // }
        } else {
            $amount = 0;
            $customer_amount = 0;
            $cartitem = [];
            $totalitems = 0;
            $cart = session()->get('cartItems');
            $ids = array_keys($cart);
            $cart = collect($cart)->groupBy('seller_id');

            $usedvariations = [];
            foreach ($cart as $key => $item) {
                $seller = Seller::find($key);
                $result = [];
                $result['seller_id'] = ($seller) ? $seller->id : '';
                $result['seller_name'] = ($seller) ? $seller->name : '';
                foreach ($item as $key => $cart_item) {
                    $cart_item = collect($cart_item);
                    $cart_item->id = $ids[$totalitems];
                    $cart_item->variation_id = $cart_item['variation_id'];
                    $cart_item->product_id = $cart_item['product_id'];
                    $cart_item->qty = $cart_item['qty'];
                    $usedvariations[] = $cart_item['variation_id'];

                    $cart_item->variation = AttributeVariationPrice::find($cart_item['variation_id']);
                    // dd($cart_item['product_id']);
                    $product = $cart_item->productdetails = Product::find($cart_item['product_id']);
                    $cart_item->productdetails->image = $cart_item->productdetails->image();
                    $product_amount = $product->getcustomerproductprice(null, $product->id, $cart_item['qty'], $cart_item['variation_id']);
                    $product_amount = $product_amount * $cart_item['qty'];
                    $amount = $amount + $product_amount;
                    $local = 'en';
                    $cart_item->productdetails->name = $product->printproductname($local, $product->id);

                    $cart_item->productdetails->customer_price = $product->getcustomerproductprice(null, $product->id, $cart_item['qty'], $cart_item['variation_id']);

                    $customer_total = $cart_item->productdetails->customer_price * $cart_item['qty'];
                    $customer_amount = $customer_amount + $customer_total;
                    // $product            = Product::find($cart_item->product_id);
                    $cart_item->productdetails->cod = ($product->cod) ? 1 : 0;
                    $cart_item->cod = ($product->cod) ? 1 : 0;
                    $result['products'][] = $cart_item;
                    $totalitems++;
                }
                $cartitem[] = $result;
            }
            $sub_total = 0; //$amount;
            $sameSellerProducts = [];
            $categoryProducts = [];
            if (session()->has('cartItems') && !empty(session()->get('cartItems'))) {

                $categories = $product->categories->pluck('category_id');

                $sameSellerProducts = Product::whereHas('categories')
                    ->where('seller_id', $product->seller_id)
                    ->inRandomOrder()
                    ->limit(4)->get();

                if (count($categories) > 0) {
                    $categoryProducts = Product::whereHas('categories', function ($query) use ($categories) {
                        $query->where('category_id', $categories);
                    })->inRandomOrder()->limit(8)->get();
                } else {
                    $categoryProducts = Product::where('name', 'like', '%' . $product->name . '%')->inRandomOrder()->limit(8)->get();
                }
            }

            // dd($cartitem);

            $vouchersofProducts = VoucherProduct::whereIn('product_id', $cartProductIds)->get()->groupBy('voucher_id')->toArray();

            $voucherIds = [];
            $productVouchers = [];
            if (count($vouchersofProducts) > 0) {
                $voucherIds = array_keys($vouchersofProducts);
                $productVouchers = Voucher::with('products:id,voucher_id,product_id')->whereIn('id', $voucherIds)
                                        ->where('usage_qty', '>', 0)->whereDate('to_date', '>', now())->get();
            }

            view('frontend.cart', compact('cartitem', 'bundleId', 'bundleDiscount', 'cartContainBundleProduct', 'amount', 'sameSellerProducts', 'categoryProducts', 'sub_total', 'totalitems', 'usedvariations', 'productVouchers', 'cartProductIds'));

            if ($cart == null) {
                $cart = [];
            }

        }
    }

    /* delete cart */
    public function deletecartproduct(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                "slug" => "required",
            ),
            [
                'slug.required' => trans('messages.cartidreq'),
            ]
        );

        if ($validator->fails()) {
            $msg = $validator->errors()->getMessages();
            $ms = "Validation error";
            foreach ($msg as $key => $value) {
                $ms = $value[0];
            }
            \Session::flash('error', $ms);
            return response::json(['success' => false, 'message' => $ms, "code" => 200], 200);
        }

        if ($request->has('type') && $request->type == 'multiple') {
            $slug = array_map(function ($item) {
                return Helper::decrypt($item);
            }, $request->slug);
        } else {
            $slug = Helper::decrypt($request->slug);
        }

        if (Auth::check()) {
            $user = Auth::user();
            $cart_array = ($request->has('type') && $request->type == 'multiple') ? $slug : explode(",", $slug);
            for ($i = 0; $i < count($cart_array); $i++) {
                $cart = Cart::where('id', $cart_array[$i])->where('user_id', $user->id)->first();
                if (!empty($cart)) {
                    $cart->delete();
                }
            }
        } else {
            $cartItems = session()->get('cartItems');
            $cart_array = ($request->has('type') && $request->type == 'multiple') ? $slug : explode(",", $slug);
            for ($i = 0; $i < count($cart_array); $i++) {
                unset($cartItems[$cart_array[$i]]);
            }
            session()->put('cartItems', $cartItems);
        }

        return response::json(['success' => true, 'message' => trans('messages.carttemdelete'), "code" => 200], 200);

    }

    /* delete move to wishlist */
    public function movetowishlist(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                "slug" => "required",
            ),
            [
                'slug.required' => trans('messages.cartidreq'),
            ]
        );

        if ($validator->fails()) {
            $msg = $validator->errors()->getMessages();
            $ms = "Validation error";
            foreach ($msg as $key => $value) {
                $ms = $value[0];
            }
            \Session::flash('error', $ms);
            return response::json(['success' => false, 'message' => $ms, "code" => 200], 200);
        }

        // $this->deletecartproduct($request);

        $slug = array_map(function ($item) {
            return Helper::decrypt($item);
        }, $request->slug);

        $user = Auth::user();
        $cart_array = ($request->has('type') && $request->type == 'multiple') ? $slug : explode(",", $slug);

        for ($i = 0; $i < count($cart_array); $i++) {
            $cart = Cart::where('id', $cart_array[$i])->where('user_id', $user->id)->first();
            if (!empty($cart)) {
                $cart->delete();
                $myRequest = new Request();
                $myRequest->setMethod('POST');
                $myRequest->request->add(['slug' => Helper::encrypt($cart->product_id)]);
                $myRequest->request->add(['variation_id' => ($cart->variation_id != '') ? Helper::encrypt($cart->variation_id) : null]);

                $wishlist = new WishlistController();
                $wishlist->wishlistaddremove($myRequest);
            }
        }
        return response::json(['success' => true, 'message' => trans('messages.carttemdelete'), "code" => 200], 200);

    }

    /* update cart */
    public function updatecart(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                "cart_id" => "required",
                "qty" => "required",
            ),
            [
                'cart_id.required' => trans('messages.cart_id.required'),
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
        $cart_id = Helper::decrypt($request->cart_id);
        if (Auth::check()) {

            $user = Auth::user();
            $cart = Cart::where('id', (int) $cart_id)->first();

            if ($cart->qty < $request->qty) {
                $product = Product::where('id', $cart->product_id)->first();
                $checkQty = ($product->is_variation == '1' && $product->variation) ? $product->variation->qty : $product->qty;
                if ($checkQty < $request->qty || $product->is_deleted == 1) {
                    return Response::json(["success" => false, "message" => trans('messages.requestqtynotavailable'), "code" => 400], 400);
                }
            }
            if ($request->has('variation_id')) {
                $cart->variation_id = $request->variation_id;
            }
            if (!empty($cart)) {
                $cart->qty = $request->qty;
                $cart->save();
            }
        } else {
            $cart = session()->get('cartItems');
            if (isset($cart[$cart_id])) {
                $cart[$cart_id]['qty'] = $request->qty;
                if ($request->has('variation_id')) {
                    $cart[$cart_id]['variation_id'] = $request->variation_id;
                }
            }
            session()->put('cartItems', $cart);
        }
        return response::json(['success' => true, 'message' => trans('messages.qtyupdate'), "code" => 200], 200);
    }

    /* add voucher url */
    public function addvoucherurl(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                "cart_value" => "required",
                "coupon_id" => "required",
            ),
            [
                'cart_value.required' => trans('messages.cartvaluerequired'),
                'coupon_id.required' => trans('messages.couponidrequired'),
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

        $coupon = [];
        $couponId = $request->coupon_id;
        $product_array = $request->product_array;
        $product_ids = array_column($product_array, 'product_id');  
        $voucherData = Helper::getVoucherData($couponId, $request->cart_value, $product_ids);

        $product_name = $voucherData['product'];
        $productID = $voucherData['productID'];
        $discountType = $voucherData['discountType'];
    
        $productData = Product::find($productID);
        $sellerOfProduct = '';
        if($productData){
            $sellerOfProduct = $productData->seller_id;
        }
        $qtyOfProduct = array_reduce($product_array, function($carry, $item) use($productID) {
            if ($item['product_id'] == $productID)
                $carry = $item;
            return $carry;
        });
    
        $coupon = Voucher::where('id', (int) $couponId)->where('min_basket_price', '<=', $request->cart_value)->first();

        $discountWithQty = $voucherData['discount'] * $qtyOfProduct['qty'];
        $cashbackWithQty = $voucherData['cashback'] * $qtyOfProduct['qty'];
        
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
            return response::json(['success' => true, 'discount' => $discount, 'coupon' => $coupon, 'product_name' => $product_name, 'sellerOfProduct' => $sellerOfProduct, "code" => 200], 200);
        }
        if($coupon && $cashback > 0){            
            return response::json(['success' => true, 'cashback' => $cashback, 'coupon' => $coupon, 'product_name' => $product_name, 'sellerOfProduct' => $sellerOfProduct, "code" => 200], 200);
        }
        return response::json(['success' => false, 'discount' => 0, "code" => 200, 'message' => "The cart amount doesn't match the minimum spend of this coupon."], 200);
    }

    /* get seller voucher */
    public function getSellerVoucher(Request $request){
        $sellerID = $request->sellerId;
        $voucherID = $request->voucherId;
        $subTotal = $request->subTotal;

        $seller = Seller::with(['vouchers' => function($q) use($subTotal) {
            $q->where('min_basket_price', '<=', $subTotal);
        }])->find($sellerID);  
        $sellervoucher = false;
        $sellerid = false;
        $promotion  = \Session::get('promotion');

        if($promotion){
            $voucherId   = $promotion['voucher_id'];
            if($promotion['type'] == 'seller'){
                $sellervoucher = Helper::decrypt($promotion['voucher_id']);
                $sellerid = $promotion['seller_id'];
            }
        }                            

        if($seller && $seller->vouchers && count($seller->vouchers) > 0){
            $returnHTML = view('frontend.sellervoucher')->with('seller', $seller)->with('sellervoucher', $sellervoucher)->with('voucherID', $voucherID)->render();
            return response()->json(array('success' => true, 'html'=>$returnHTML));
        }
    }

    /* set seller voucher */
    public function setSellerVoucher(Request $request){
        $sellerId = $request->seller_id;
        $voucherId = $request->voucher_id;
        $subTotal = $request->sub_total;
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
    }

    /* check coin */
    public function checkCoin(Request $request){
        $total = $request->total;
        $coinBalance = Auth::user()->coin_balance;
        $coinManagement = CoinManagement::first();
        $claimCoins = 0;
        $rmCanClaim = 0;

        if($coinManagement &&  ($total >= $coinManagement->min_order_amount) ){
            if($coinManagement->max_use_coin_per_order_type == 'amount'){
                $claimCoins = $coinManagement->max_use_coin_per_order_amount > $total ? $total : $coinManagement->max_use_coin_per_order_amount;
            }else{
                $coinCount = ($total * $coinManagement->max_use_coin_per_order_discount)/100;
                $claimCoins = $coinCount > $total ? $total : $coinCount;
            }
            $claimCoins =  Auth::user()->coin_balance >= $claimCoins ? $claimCoins : Auth::user()->coin_balance;
            $coinToRM =  ($claimCoins * $coinManagement->coin_to_rm);
            if($coinToRM > $total){
                $rmCanClaim = (float)$total;
            }else{
                $rmCanClaim = (float)$coinToRM;
            }
        }
        $rmCanClaim = (float)$rmCanClaim;
        $claimCoins = (float)$rmCanClaim/$coinManagement->coin_to_rm;
        return response::json(['success' => true, 'rmOfCoins' => $rmCanClaim, 'claimCoins'=> $claimCoins, "code" => 200], 200);
    }

    public function getUserAddress(Request $request){
        $user = Auth::user();
        if($user->role_id == '15'){
            if($request->type == 'self'){
                $address = ($user->defaultStaffAddress != '' && $user->defaultStaffAddress != null) ? $user->defaultStaffAddress : $user->staffReceivers()->first();
                return response::json(['success' => true, 'address' => $address, "code" => 200], 200);
            }
            $address = ($user->defaultStaffCustomerAddress != '' && $user->defaultStaffCustomerAddress != null) ? $user->defaultStaffCustomerAddress : $user->staffCustomerReceivers()->first();
            return response::json(['success' => true, 'address' => $address, "code" => 200], 200);
        }
        else{
            if($request->type == 'self'){
                $address = ($user->defaultAgentAddress != '' && $user->defaultAgentAddress != null) ? $user->defaultAgentAddress : $user->agentReceivers()->first();
                return response::json(['success' => true, 'address' => $address, "code" => 200], 200);
            }
            $address = ($user->defaultAgentCustomerAddress != '' && $user->defaultAgentCustomerAddress != null) ? $user->defaultAgentCustomerAddress : $user->agentCustomerReceivers()->first();
            return response::json(['success' => true, 'address' => $address, "code" => 200], 200);
        }
    }
}
