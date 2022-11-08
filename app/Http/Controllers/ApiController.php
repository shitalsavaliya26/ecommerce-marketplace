<?php

namespace App\Http\Controllers;

use App\Agentreceiver;
use App\AttributeVariationPrice;
use App\Bank;
use App\Bankdetail;
use App\BundleDeal;
use App\Cart;
use App\Coupon;
use App\CouponProduct;
use App\CouponReport;
use App\Helpers\Helper;
use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WishlistController;
use App\Notifications\OrderCancelled;
use App\Oldorderhistory;
use App\Order;
use App\OrderAddress;
use App\OrderProduct;
use App\Product;
use App\PushNotification;
use App\Seller;
use App\ShippingCompany;
use App\ShippingCompanySeller;
use App\Staffreceiver;
use App\State;
use App\Transactionhistoriesagent;
use App\Transactionhistoriescustomer;
use App\Transactionhistoriesstaff;
use App\User;
use App\UserAddress;
use App\VoucherProduct;
use App\Voucher;
use App\CoinManagement;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Notification;
use Response;
use Validator;

class ApiController extends Controller
{
    /* add to cart **/
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
                        // if ($user->role_id == 7) {
                        // } else if ($user->role_id == 15) {
                        //     $cart_item->productdetails->staff_price     = $product->getstaffproductprice($user, $product->id, $cart_item->qty,$cart_item->variation_id);
                        //     $cart_item->productdetails->customer_price  = $product->getcustomerproductprice(null, $product->id, $cart_item->qty,$cart_item->variation_id);
                        // } else {
                        //     $cart_item->productdetails->customer_price  = $product->getcustomerproductprice(null, $product->id, $cart_item->qty,$cart_item->variation_id);
                        // }

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

    /* place customer order */
    public function customerPlaceOrder(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response::json(['success' => false, 'message' => 'Token not found', "code" => 302], 302);
        }
        $validator = Validator::make(
            $request->all(),
            array(
                "payment_method" => "required",
                "shipping_company" => "required",
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
            return response::json(['success' => false, 'message' => $ms, "code" => 400], 400);
        }
        $shippingcomapanies = json_decode($request->shipping_company);

        $cartItems = Cart::wherehas('productdetails', function ($query) {
            $query->where('is_deleted', '0')->where('status', "active");
        })->where('user_id', $user->id)->get();
        if (count($cartItems) <= 0) {
            return response::json(['success' => false, 'message' => trans('messages.notfoundcart'), "code" => 500], 500);
        }
        $discount = 0;
        $weight = 0;
        $shippingCharge = 0;
        $address = UserAddress::where('id', $request->address_id)->first();
        if ($cartItems != null) {
            $cod_avail = [];
            foreach ($cartItems as $value) {
                $product = Product::where('id', $value->product_id)->first();
                if (!empty($cod_avail) && !in_array($product->cod, $cod_avail)) {
                    //return response::json(['success' => false, 'message' => trans('messages.chooseproductwithsameshippingmethod'), "code" => 500], 500);
                }
                $cod_avail[] = $product->cod;
                if ($product->qty < $value->qty || $product->is_deleted == 1) {
                    return response::json(['success' => false, 'message' => trans('messages.productnothaveqty'), "code" => 500], 500);
                }
                if ($product->free_shipping == '0') {
                    $product_weight = $product->weight * $value->qty;
                    $weight = $weight + $product_weight;
                }

                if (isset($request->coupon_id)) {
                    $products = CouponProduct::where('coupon_id', $request->coupon_id)->pluck('product_id')->toArray();
                    if (in_array($value->product_id, $products)) {
                        $today = Carbon::today()->format('Y-m-d');
                        $coup = Coupon::where('id', $request->coupon_id)
                            ->whereHas('couponproduct', function ($query) use ($value) {
                                $query->where('product_id', $value->product_id);
                            })->first();

                        if ($coup) {
                            $coupon = Coupon::where('id', $request->coupon_id)
                                ->whereHas('couponproduct', function ($query) use ($value) {
                                    $query->where('product_id', $value->product_id);
                                })
                                ->where('total_qty', '>', 0)
                                ->whereDate('expiry_date', '>=', $today)
                                ->first();
                            if (!$coupon) {
                                return response::json(['success' => false, 'message' => 'Sorry! coupon not available.', "code" => 400], 400);
                            }

                            $usage = CouponReport::where('coupon_id', $coupon->id)
                                ->where('user_id', $user->id)
                                ->count();
                            // print_r($usage);die();
                            if ($usage >= $coupon->usage_per_user) {
                                return response::json(['success' => false, 'message' => 'You have already used this coupon.', "code" => 400], 400);
                            }
                            $products = CouponProduct::where('coupon_id', $request->coupon_id)->pluck('product_id')->toArray();
                            if (in_array($value->product_id, $products)) {
                                $product = Product::where('id', $value->product_id)->first();
                                $amount = $product->getcustomerproductprice($user, $value->product_id, $value->qty, $value->variation_id);

                                $qtyamount = $amount * $value->qty;
                                if ($coupon->discount_type == 'percent') {
                                    // if($coupon->usage_per_user > 1){
                                    //     $discount = ($coupon->discount * $qtyamount) / 100;

                                    // }else{
                                    $discount = ($coupon->discount * $amount) / 100;

                                    // }
                                } elseif ($coupon->discount_type == 'coin') {
                                    $discount = $coupon->discount;
                                } else {
                                    $discount = $coupon->discount;
                                }
                            }
                        }
                    }
                }
            }

            $shippingmethod = $this->getShippingCharge($address, $weight, $user, $cartItems->groupBy('seller_id'), $shippingcomapanies);
            // dd($shippingmethod);
            if (!$shippingmethod) {
                return response::json(['success' => false, 'message' => 'Shipping method not available!', "code" => 500], 500);
            }

            $shippingChargeActual = 0;
            $shippingAgent = 0;
            $shippingStaff = 0;

            foreach ($shippingmethod as $company) {
                $shippingCharge += array_sum(array_column($company[0], 'price'));
                $shippingChargeActual += array_sum(array_column($company[0], 'actual_price'));
                $shippingAgent += array_sum(array_column($company[0], 'agent_price'));
                $shippingStaff += array_sum(array_column($company[0], 'staff_price'));

            }
            // dd($shippingCharge);

            if (!empty($request->transaction_id)) {
                $transaction_id = $request->transaction_id;
            } else {
                $transaction_id = uniqid();
            }

            if ($request->payment_method == 4) {
                if ($request->file('bank_receipt') != null) {
                    $extension = strtolower($request->file('bank_receipt')->getClientOriginalExtension());
                    //print_r($extension);exit();
                    $accepted_extension = ['jpeg', 'jpg', 'png', 'pdf', 'doc'];
                    if (!in_array($extension, $accepted_extension)) {
                        return response::json(['success' => false, 'message' => trans('messages.invalid_receipt_extension'), "code" => 500], 500);
                    }
                }

                if ($request->file('bank_receipts') != null) {
                    $receipts = $request->file('bank_receipts');
                    foreach ($receipts as $receipt) {
                        $extension = strtolower($receipt->getClientOriginalExtension());
                        $accepted_extension = ['jpeg', 'jpg', 'png', 'pdf', 'doc'];
                        if (!in_array($extension, $accepted_extension)) {
                            return response::json(['success' => false, 'message' => trans('messages.invalid_receipt_extension'), "code" => 500], 500);
                        }
                    }
                }
            }

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
                'coupon_id' => isset($request->coupon_id) ? $request->coupon_id : 0,
                'discount' => $discount,
                'shipping_details' => json_encode($shippingmethod),
            ]);
            if ($shippingChargeActual > $shippingCharge) {
                if ($user->parent && $user->parent->role_id < 7) {
                    $order->update(['shipping_paid_by_agent' => ($shippingAgent)]);
                } else {
                    $order->update(['shipping_paid_by_company' => ($shippingChargeActual - $shippingCharge)]);

                }
            }
            if ($user->parent && $user->parent->role_id == 15) {
                $order->update(['shipping_paid_by_staff' => ($shippingStaff)]);
            }
            foreach ($shippingmethod as $company) {
                $value = array_values($company[0])[0];
                $order->counriercompanies()->create(['seller_id' => $value['seller_id'], 'price' => $value['price'], 'shipping_company' => $value['shipping_company'], 'detail' => json_encode($value)]);
            }

            foreach ($shippingmethod[0][0] as $key => $shipping) {
                if ($shipping['tracking_number'] > 1) {
                    for ($i = 0; $i < $shipping['tracking_number']; $i++) {
                        $order->tracking_no()->create(['seller_id' => $key, 'price' => $shipping['price'], 'tracking_number' => '']);
                    }
                } else {
                    $order->tracking_no()->create(['seller_id' => $key, 'price' => $shipping['price'], 'tracking_number' => '']);
                }
            }

            $order = Order::where('id', $order->id)->first();
            $order->order_id = "ORDER" . sprintf("%06d", $order->id);
            /** Uploading bank receipt for manual bank payment method */
            if ($request->payment_method == 4) {
                if ($request->file('bank_receipt') != null) {
                    try
                    {
                        $receipts = $request->file('bank_receipt');
                        $filename = microtime(true) . rand(00000, 99999) . '.' . $receipts->getClientOriginalExtension();
                        $receipts->move(public_path('bank_receipts/'), $filename);
                        $order->bank_receipt = $filename;
                    } catch (\Exception $e) {

                    }
                }

                if ($request->file('bank_receipts') != null) {
                    try
                    {
                        $receipts = $request->file('bank_receipts');
                        foreach ($receipts as $key => $receipt) {
                            if ($key == 0) {
                                $filename = microtime(true) . rand(00000, 99999) . '.' . $receipt->getClientOriginalExtension();
                                $receipt->move(public_path('bank_receipts/'), $filename);
                                $order->bank_receipt = $filename;
                            }
                            if ($key == 1) {
                                $filename = microtime(true) . rand(00000, 99999) . '.' . $receipt->getClientOriginalExtension();
                                $receipt->move(public_path('bank_receipts/'), $filename);
                                $order->bank_receipt2 = $filename;
                            }
                        }
                    } catch (\Exception $e) {

                    }
                }
            }
            $order->save();
            // $shippingCompany = ShippingCompany::where('id', $request->shipping_company)->first();
            // if (count($shippingCompany) > 0) {
            //     /** For Delivery */
            //     if ($shippingCompany->slug != "self-collect") {
            //         $address = UserAddress::where('id', $request->address_id)->first();
            //         if ($address != null) {
            //             if ($address->is_default != "true") {
            //                 $falseaddress = UserAddress::where('user_id', $user->id)->update(['is_default' => "false"]);
            //                 $address->is_default = "true";
            //                 $address->save();
            //             }
            //             $orderaddress = OrderAddress::create([
            //                 'order_id' => $order->id,
            //                 'name' => $address->name,
            //                 'contact_number' => $address->contact_number,
            //                 'address_line1' => $address->address_line1,
            //                 'address_line2' => $address->address_line2,
            //                 'state' => $address->state,
            //                 'town' => $address->town,
            //                 'postal_code' => $address->postal_code,
            //                 'country' => $address->country,
            //                 'country_code' => $address->country_code,
            //             ]);
            //         }
            //     } else {
            //         /** SELF COLLECT */
            //         $selfCollect = ShippingCompany::where('slug', 'self-collect')->first();
            //         if ($selfCollect != null) {
            //             $orderaddress = OrderAddress::create([
            //                 'order_id' => $order->id,
            //                 'self_pickup_address' => $selfCollect->address,
            //             ]);
            //         }
            //     }
            // }

            $address = UserAddress::where('id', $request->address_id)->first();
            if ($address != null) {
                if ($address->is_default != "true") {
                    $falseaddress = UserAddress::where('user_id', $user->id)->update(['is_default' => "false"]);
                    $address->is_default = "true";
                    $address->save();
                }
                $orderaddress = OrderAddress::create([
                    'order_id' => $order->id,
                    'name' => $address->name,
                    'contact_number' => $address->contact_number,
                    'address_line1' => $address->address_line1,
                    'address_line2' => $address->address_line2,
                    'state' => $address->state,
                    'town' => $address->town,
                    'postal_code' => $address->postal_code,
                    'country' => $address->country,
                    'country_code' => $address->country_code,
                ]);
            }

            $totalamount = $shippingCharge;
            $agent_price_amount = 0;

            foreach ($cartItems as $value) {
                $product = Product::where('id', $value->product_id)->first();
                $amount = $product->getcustomerproductprice($user, $value->product_id, $value->qty, $value->variation_id);
                $agentamount = $product->get_product_price($user->parent, $value->product_id, $value->variation_id);

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

                ]);
                if (isset($request->coupon_id)) {
                    $coup = Coupon::where('id', $request->coupon_id)
                        ->whereHas('couponproduct', function ($query) use ($value) {
                            $query->where('product_id', $value->product_id);
                        })->first();

                    if ($coup) {
                        $coupon = Coupon::where('id', $request->coupon_id)
                            ->whereHas('couponproduct', function ($query) use ($value) {
                                $query->where('product_id', $value->product_id);
                            })
                            ->first();
                        $products = $coupon->couponproduct->pluck('product_id')->toArray();
                        if (in_array($value->product_id, $products)) {
                            $coupon->decrement('total_qty', 1);
                            CouponReport::create(['coupon_id' => $coupon->id,
                                'user_id' => $user->id,
                                'product_id' => $value->product_id,
                                'order_id' => $order->id,
                                'redeemed_date' => Carbon::now(),
                            ]);
                            $orderprouct->update(['discount' => $discount]);
                        }
                    }
                }

                $product->qty = $product->qty - $value->qty;
                $product->save();
            }
            $totalamount = round($totalamount - $discount, 2);
            $order->total_amount = $totalamount;
            if ($totalamount < 0) {
                return response::json(['success' => false, 'message' => 'Something went wrong!', "code" => 500], 500);
            }
            $order->save();
            Transactionhistoriescustomer::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'status' => $order->status,
                'transaction_id' => $order->transaction_id,
                'transaction_for' => "payment",
                'amount' => '-' . round($totalamount),
                'payment_by' => $request->payment_method,
            ]);
            $cart = Cart::where('user_id', $user->id)->delete();
            return response::json(['success' => true, "payload" => array("order_id" => $order->id, "totalamount" => round($totalamount, 2)), 'message' => trans('messages.orderplaced'), "code" => 200], 200);
        } else {
            return response::json(['success' => false, 'message' => trans('messages.notfoundcart'), "code" => 500], 500);
        }

    }

    public function validatecart(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response::json(['success' => false, 'message' => 'Token not found', "code" => 302], 302);
        }

        $cart = Cart::wherehas('productdetails', function ($query) {
            $query->where('is_deleted', '0')
                ->where('status', "active");
        })->with('variation')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($item) {
                $item->variation_value = $item->variation;
                unset($item->variation);
                return $item;
            })->groupBy('seller_id');
        $local = ($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'en';

        if (!empty($cart)) {
            $amount = 0;
            $customer_amount = 0;
            $response = [];
            $is_validate = true;
            foreach ($cart as $key => $item) {
                $seller = Seller::find($key);
                $result = [];
                $result['seller_id'] = $seller->id;
                $result['seller_name'] = $seller->name;
                foreach ($item as $cart_item) {

                    $product = $cart_item->productdetails;
                    $cart_item->productdetails->image = $cart_item->productdetails->image();
                    $product_amount = $cart_item->getproductprice($user, $product->id, $cart_item->qty, $cart_item->variation_id);
                    $product_amount = $product_amount * $cart_item->qty;
                    $amount = $amount + $product_amount;
                    $cart_item->productdetails->name = $product->printproductname($local, $product->id);

                    if ($user->role_id == 7) {
                        $cart_item->productdetails->customer_price = $product->getcustomerproductprice($user, $product->id, $cart_item->qty, $cart_item->variation_id);
                    } else if ($user->role_id == 15) {
                        $cart_item->productdetails->staff_price = $product->getstaffproductprice($user, $product->id, $cart_item->qty, $cart_item->variation_id);
                        $cart_item->productdetails->customer_price = $product->getcustomerproductprice(null, $product->id, $cart_item->qty, $cart_item->variation_id);
                    } else {
                        $cart_item->productdetails->customer_price = $product->getcustomerproductprice(null, $product->id, $cart_item->qty, $cart_item->variation_id);
                    }

                    $customer_total = $cart_item->productdetails->customer_price * $cart_item->qty;
                    $customer_amount = $customer_amount + $customer_total;
                    $product = Product::find($cart_item->product_id);
                    $cart_item->productdetails->cod = ($product->cod) ? 1 : 0;
                    $cart_item->cod = ($product->cod) ? 1 : 0;
                    $result['products'][] = $cart_item;
                    if ($cart_item->variation_value) {

                    } else {

                    }
                    if ($product->qty < $cart_item->qty || $product->is_deleted == 1) {
                        $is_validate = false;
                        $cart_item->error = trans('messages.noqtyforproduct') . $product->name;
                    } else {
                        $cart_item->error = null;
                    }
                }
                $response[] = $result;
            }

            // $amount = 0;
            // $customer_amount = 0;
            // $is_validate = true;
            // foreach ($cart as $cart_item) {
            //     $product = $cart_item->productdetails;
            //     $cart_item->productdetails->image = $cart_item->productdetails->image();

            //     $product_amount = $cart_item->getproductprice($user, $product->id, $cart_item->qty);
            //     $product_amount = $product_amount * $cart_item->qty;
            //     $amount = $amount + $product_amount;
            //     $customer_price = $product->getcustomerproductprice(null, $product->id, $cart_item->qty);
            //     $customer_price = $customer_price * $cart_item->qty;
            //     $customer_amount = $customer_amount + $customer_price;
            //     $product = Product::where('id', $product->id)->first();
            //     if ($product->qty < $cart_item->qty || $product->is_deleted == 1) {
            //         $is_validate = false;
            //         $cart_item->error = trans('messages.noqtyforproduct') . $product->name;
            //     } else {
            //         $cart_item->error = null;
            //     }
            //     $cart_item->productdetails->customer_price = $product->getcustomerproductprice($user, $product->id, $cart_item->qty);
            // }
            $cart->sub_total = $amount;
            return Response::json(["success" => true, "payload" => array("cart" => $response, "is_validate" => $is_validate, "amount" => round($amount, 2), "customer_amount" => $customer_amount), "message" => "Cart product", "code" => 200], 200);
        } else {
            return Response::json(["success" => true, "payload" => array("cart" => $cart), "message" => "Cart product", "code" => 200], 200);
        }
    }

    public function getShippingCharge($address, $weight, $user, $shipping_ids, $shippingcompany)
    {

        $response = [];
        foreach ($shipping_ids as $key => $shipping) {
            $pricearr = [];
            // dd($shipping);
            // $shipping = json_decode($shipping);
            $seller = Seller::find($shipping[0]->seller_id);

            $shippingcompany_id = collect($shippingcompany)->filter(function ($value, $key) use ($seller) {
                return $value->seller_id == $seller->id;
            })->values();
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
            $state = State::where('name', $state)->first();

            $item1 = $item = Cart::wherehas('productdetails', function ($query) {
                $query->where('is_deleted', '0')
                    ->where('status', "active");
            })->with('variation')
                ->where('user_id', $user->id)
                ->where('seller_id', $seller->id)
                ->get()
                ->map(function ($item) {
                    $item->variation_value = $item->variation;
                    unset($item->variation);
                    return $item;
                });
            foreach ($item as $cart_item) {
                $product = Product::select('id', 'name', 'weight', 'height', 'width', 'length', 'free_shipping', 'deduct_agent_wallet')->where('id', $cart_item->product_id)->first();
                if ($product->free_shipping == '0') {
                    if ($cart_item->variation_id && $cart_item->variation_id != 0) {
                        $product_weight = $cart_item->variation_value->weight * $cart_item->qty;
                        $weight += $product_weight;
                        $volume += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item->qty;
                    } else {
                        $product_weight = $product->weight * $cart_item->qty;
                        $weight += $product_weight;
                        $volume += ($product->height * $product->width * $product->length) * $cart_item->qty;
                    }
                } else {
                    if ($cart_item->variation_id && $cart_item->variation_id != 0) {
                        $product_weight = $cart_item->variation_value->weight * $cart_item->qty;
                        $weightstaffagent += $product_weight;
                        $volumestaffagent += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item->qty;
                    } else {
                        $product_weight = $product->weight * $cart_item->qty;
                        $weightstaffagent += $product_weight;
                        $volumestaffagent += ($product->height * $product->width * $product->length) * $cart_item->qty;
                    }
                }

                if ($product->free_shipping == '1' && $product->deduct_agent_wallet == '1') {
                    if ($cart_item->variation_id && $cart_item->variation_id != 0) {
                        $product_weightagent = $cart_item->variation_value->weight * $cart_item->qty;
                        $weightagent += $product_weightagent;
                        $volumeagent += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item->qty;
                    } else {
                        $product_weightagent = $product->weight * $cart_item->qty;
                        $weightagent += $product_weightagent;
                        $volumeagent += ($product->height * $product->width * $product->length) * $cart_item->qty;
                    }
                }
                if ($cart_item->variation_id && $cart_item->variation_id != 0) {
                    $actualweight += $cart_item->variation_value->weight * $cart_item['qty'];
                    $actualvolume += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item['qty'];
                } else {

                    $actualweight += $product->weight * $cart_item['qty'];
                    $actualvolume += ($product->height * $product->width * $product->length) * $cart_item['qty'];
                }
            }

            $sellercompanyId = ShippingCompanySeller::where('seller_id', $seller->id)->where('shipping_company_id', $shippingcompany_id[0]->shipping_company)->distinct()
                ->pluck('shipping_company_id')->toArray();

            $response[] = ShippingCompany::whereHas('shippingcompanyseller', function ($query) use ($seller, $state) {
                $query->where('seller_id', $seller->id)->where('state_id', $state->id);
            })
            // ->whereHas('shippingcompanystate',function($query) use ($address){
            //     $query->where('state',$address->state);
            // })
                ->where('id', $shippingcompany_id[0]->shipping_company)
                ->select('id')
                ->get()
                ->map(function ($item) use ($weight, $state, $volume, &$pricearr, $shipping, $item1, $seller, $actualvolume, $actualweight, $weightagent, $volumeagent) {
                    //$item->price = $item->getShippingPrice($weight,$state,$volume,$item);
                    $no_track = 0;
                    $item->shippingcompanyseller = ShippingCompanySeller::where('seller_id', $seller->id)->where('state_id', $state->id)->get();
                    if ($volume > $item->max_volume && $item->max_volume > 0) {
                        $number = ceil($volume / $item->max_volume);
                        $tracking_number = $number;
                    } else {
                        $tracking_number = 1;
                    }
                    if ($weight > 0 && $item->max_weight > 0) {
                        $no_track = ceil($weight / $item->max_weight);
                    } else {
                        $item->price = 0;
                    }
                    if ($weight > $item->max_weight && $item->max_weight > 0) {
                        $no_track = ceil($weight / $item->max_weight);
                    }
                    if ($no_track > $tracking_number) {
                        $tracking_number = $no_track;
                    }
                    // $item->tracking_number = $tracking_number;
                    // $item->weight = $weight;
                    $pricearr[$shipping[0]->seller_id] = ['tracking_number' => $tracking_number, 'price' => $item->getShippingPrice($weight, $state, $volume, $item), 'volume' => $volume, 'weight' => $weight, 'items' => $item1, 'seller_id' => $seller->id, 'shipping_company' => $item->id, 'actual_price' => $item->getShippingPrice($actualweight, $state, $actualvolume, $item), 'agent_price' => ($weightagent > 0) ? $item->getShippingPrice($weightagent, $state, $volumeagent, $item) : 0, 'staff_price' => ($weightstaffagent > 0) ? $item->getShippingPrice($weightstaffagent, $state, $volumestaffagent, $item) : 0];
                    // $pricearr['items'] = $item1;
                    // $pricearr['seller_id'] = $seller->id;
                    unset($item->shippingcompanyseller);
                    return $pricearr;
                });
            // print_r($response);
            // $all_methods_have_seller = (count($response) > 0  && $all_methods_have_seller != 0) ? 1 : 0;
            // $response[] = $company;
        }
        //dd($response);

        if (!$all_methods_have_seller) {
            return false;
        }
        return $response;

    }

    public function getShippingChargeUpdated($address, $weight, $user, $shipping_ids, $shippingcompany)
    {

        $pricearr = [];
        foreach ($shipping_ids as $key => $shipping) {
            // $shipping = json_decode($shipping);
            $seller = Seller::find($key);
            $shippingcompany_id = collect($shippingcompany)->filter(function ($value, $key) use ($seller) {
                return $value->seller_id == $seller->id;
            })->values();
            // $company['seller_name'] = $seller->name;
            $weight = 0;
            $volume = 0;
            $actualweight = 0;
            $actualvolume = 0;
            $weightagent = 0;
            $volumeagent = 0;
            $weightstaffagent = 0;
            $volumestaffagent = 0;
            $response = [];
            $all_methods_have_seller = 1;
            $state = $address->state;
            $state = State::where('name', $state)->first();
            //dd($state);
            // $item = Cart::wherehas('productdetails', function ($query) {
            //                 $query->where('is_deleted', '0')
            //                 ->where('status', "active");
            //             })->with('variation')
            //             ->where('user_id', $user->id)
            //             ->where('seller_id',$seller->id)
            //             ->get()
            //             ->map(function($item){
            //                 $item->variation_value = $item->variation;
            //                 unset($item->variation);
            //                 return $item;
            //             });

            foreach ($shipping as $cart_item) {
                $product = Product::select('id', 'name', 'weight', 'height', 'width', 'length', 'free_shipping')->where('id', $cart_item['product_id'])->first();
                if ($product->free_shipping == '0') {
                    if ($cart_item['variation_id'] && $cart_item['variation_id'] != 0) {
                        $product_weight = $cart_item->variation_value->weight * $cart_item['qty'];
                        $weight += $product_weight;
                        $volume += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item['qty'];
                    } else {
                        $product_weight = $product->weight * $cart_item['qty'];
                        $weight += $product_weight;
                        $volume += ($product->height * $product->width * $product->length) * $cart_item['qty'];
                    }
                } else {
                    if ($cart_item->variation_id && $cart_item->variation_id != 0) {
                        $product_weight = $cart_item->variation_value->weight * $cart_item->qty;
                        $weightstaffagent += $product_weight;
                        $volumestaffagent += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item->qty;
                    } else {
                        $product_weight = $product->weight * $cart_item->qty;
                        $weightstaffagent += $product_weight;
                        $volumestaffagent += ($product->height * $product->width * $product->length) * $cart_item->qty;
                    }
                }
                if ($product->free_shipping == '1' && $product->deduct_agent_wallet == '1') {
                    if ($cart_item['variation_id'] && $cart_item['variation_id'] != 0) {
                        $product_weightagent = $cart_item->variation_value->weight * $cart_item['qty'];
                        $weightagent += $product_weightagent;
                        $volumeagent += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item['qty'];
                    } else {
                        $product_weightagent = $product->weight * $cart_item['qty'];
                        $weightagent += $product_weightagent;
                        $volumeagent += ($product->height * $product->width * $product->length) * $cart_item['qty'];
                    }
                }
                if ($cart_item['variation_id'] && $cart_item['variation_id'] != 0) {
                    $actualweight += $cart_item->variation_value->weight * $cart_item['qty'];
                    $actualvolume += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item['qty'];
                } else {

                    $actualweight += $product->weight * $cart_item['qty'];
                    $actualvolume += ($product->height * $product->width * $product->length) * $cart_item['qty'];
                }
                // if($product->free_shipping == '0'){

                //     $product_weight = $product->weight * $cart_item['qty'];
                //     $weight += $product_weight;
                //     $volume += ($product->height * $product->width * $product->length);
                // }
                // $actualweight += $product->weight * $cart_item['qty'];
                // $actualvolume += ($product->height * $product->width * $product->length);
            }
            //dd($shippingcompany_id);
            $sellercompanyId = ShippingCompanySeller::where('seller_id', $seller->id)->where('shipping_company_id', $shippingcompany_id[0]->shipping_company)->distinct()
                ->pluck('shipping_company_id')->toArray();
            //
            $response[] = ShippingCompany::whereHas('shippingcompanyseller', function ($query) use ($seller, $state) {
                $query->where('seller_id', $seller->id)->where('state_id', $state->id);
            })
            // ->whereHas('shippingcompanystate',function($query) use ($address){
            //     $query->where('state',$address->state);
            // })
                ->where('id', $shippingcompany_id[0]->shipping_company)
                ->select('id')
                ->get()
                ->map(function ($item) use ($weight, $state, $volume, &$pricearr, $shipping, $key, $actualvolume, $actualweight, $seller, $weightagent, $volumeagent) {
                    //$item->price = $item->getShippingPrice($weight,$state,$volume,$item,$item1,$seller);
                    $item->shippingcompanyseller = ShippingCompanySeller::where('seller_id', $seller->id)->where('state_id', $state->id)->get();
                    $no_track = 0;
                    if ($volume > $item->max_volume && $item->max_volume > 0) {
                        $number = ceil($volume / $item->max_volume);
                        $tracking_number = $number;
                    } else {
                        $tracking_number = 1;
                    }
                    if ($weight > $item->max_weight && $item->max_weight > 0) {
                        $no_track = ceil($weight / $item->max_weight);
                    }
                    if ($no_track > $tracking_number) {
                        $tracking_number = $no_track;
                    }
                    $pricearr[$key] = ['tracking_number' => $tracking_number, 'price' => $item->getShippingPrice($weight, $state, $volume, $item), 'volume' => $volume, 'weight' => $weight, 'items' => $shipping, 'seller_id' => $seller->id, 'shipping_company' => $item->id, 'actual_price' => $item->getShippingPrice($actualweight, $state, $actualvolume, $item), 'agent_price' => ($weightagent > 0) ? $item->getShippingPrice($weightagent, $state, $volumeagent, $item) : 0, 'staff_price' => ($weightstaffagent > 0) ? $item->getShippingPrice($weightstaffagent, $state, $volumestaffagent, $item) : 0];
                    unset($item->shippingcompanyseller);
                    return $pricearr;
                });

            $all_methods_have_seller = (count($response) > 0 && $all_methods_have_seller != 0) ? 1 : 0;
            // $response[] = $company;
        }
        //dd($response);
        if (!$all_methods_have_seller) {
            return false;
        }
        return $response;

    }

    public function getpaymentmethod2($postalcode, $weight, $user, $type)
    {
        //
        $selfCollect = ShippingCompany::where('slug', 'self-collect')->first();
        $shippingCompanies = ShippingCompany::where('status', "active")->with('shippingcompanypricetier')->wherehas('shippingcompanystate', function ($query) use ($postalcode) {
            $query->where('state', $postalcode);
        })->where(function ($query2) use ($type) {
            if ($type == 1) {
                $query2->where('cod', 1);
            }
            if ($type == 3) {
                $query2->where('wallet', 1);
            }
            if ($type == 4) {
                $query2->where('manual_bank', 1);
            }
        })->get();

        $response = [];

        if (count($shippingCompanies) > 0) {
            $key = 0;
            $arrShippingCompanies = array();
            foreach ($shippingCompanies as $key => $value) {

                $response['type'] = $type;
                if ($type == 1) {
                    $response['name'] = "COD";
                }
                if ($type == 3) {
                    $response['name'] = "Wallet";
                }
                if ($type == 4) {
                    $response['name'] = "Manual Bank";
                }

                $objCompnay = array();

                if ($value->shippingcompanypricetier != null) {

                    foreach ($value->shippingcompanypricetier as $key1 => $value1) {
                        if ((float) $weight > (float) $value1->min_weight && (float) $weight <= (float) $value1->max_weight) {
                            if ($type == 1) {
                                $objCompnay['price'] = $value1->cod_price;
                            } else {
                                $objCompnay['price'] = $value1->other_price;
                            }
                        }
                    }
                }
                if (!isset($objCompnay['price'])) {
                    continue;
                }

                $objCompnay['id'] = $value->id;
                $objCompnay['name'] = $value->name;
                $objCompnay['slug'] = $value->slug;

                $arrShippingCompanies[] = $objCompnay;

            }
            if ($selfCollect->status == "active") {
                /** SELF COLLECT */
                $objCompnay = array();
                $objCompnay['id'] = $selfCollect->id;
                $objCompnay['name'] = $selfCollect->name;
                $objCompnay['slug'] = "self-collect";
                $objCompnay['price'] = 0;

                $arrShippingCompanies[] = $objCompnay;
            }

            $response['shippingcompany'] = $arrShippingCompanies;
        } else {
            if ($selfCollect->status == "active") {
                $response = [];
                $key = 0;
                /** SELF COLLECT */
                $response['shippingcompany'][$key]['id'] = $selfCollect->id;
                $response['shippingcompany'][$key]['name'] = $selfCollect->name;
                $response['shippingcompany'][$key]['slug'] = "self-collect";
                $response['shippingcompany'][$key]['price'] = 0;
            }
        }
        return $response;
    }

    public function cancelorder(Request $request)
    {
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
            return response::json(['success' => false, 'message' => $ms, "code" => 400], 400);
        }
        $order = Order::where('id', $request->order_id)->first();
        if ($order->status == "pending") {
            /*meanse wallet*/
            if ($order->payment_by == 3) {
                if ($order->role_id != 7) /*agent order*/ {
                    if ($order->role_id == 15) {
                        $history = Transactionhistoriesstaff::where('transaction_for', "payment")->where('order_id', $request->order_id)->first();
                        $amount = preg_replace('#[-]#', "", $history->amount);
                        $userwallet = User::where('id', $order->user_id)->first();
                        $userwallet->wallet_amount = $userwallet->wallet_amount + $amount;
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
                    } else {
                        $history = Transactionhistoriesagent::where('transaction_for', "payment")->where('order_id', $request->order_id)->first();
                        $amount = preg_replace('#[-]#', "", $history->amount);
                        $userwallet = User::where('id', $order->user_id)->first();
                        $userwallet->wallet_amount = $userwallet->wallet_amount + $amount;
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
            }
            $order->status = "cancelled";
            $order->cancel_order_reason = $request->reason;
            $order->save();
            if ($order->coupon_id != 0) {
                Coupon::where('id', $order->coupon_id)->increment('total_qty', 1);
            }
            $user = $order->user;
            if ($order->coupon_id != 0) {
                Coupon::where('id', $order->coupon_id)->increment('total_qty', 1);
            }
            Notification::send($user, new OrderCancelled($order->order_id));
            NotificationHelper::send_pushnotification($user, 'Order Cancelled', 'Your order cancelled', 0, $order->id);
            PushNotification::create(['receiver_id' => $user->id, 'sender_id' => 1, 'message' => 'order cancelled', 'type' => 'order_cancelled', 'order_id' => $order->id]);

            return response::json(['success' => true, 'message' => trans('messages.ordercancel'), "code" => 200], 200);
        } else {
            return response::json(['success' => false, 'message' => trans('messages.orderpending'), "code" => 400], 400);
        }

    }

    public function updateorder(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response::json(['success' => false, 'message' => 'token not found', "code" => 400], 400);
        }

        if ($user->role_id == 15) {
            $validator = Validator::make(
                $request->all(),
                array(
                    "order_id" => "required",
                    "product_array" => "required",
                    "receiver_id" => "required",
                    // "shipping_company" => "required",
                    // "shipping_charge" => "required",
                ),
                [
                    'order_id.required' => trans('messages.order_id.required'),
                    'product_array.required' => trans('messages.product_id.required'),
                    'receiver_id.required' => trans('messages.receiver_id.required'),
                    'shipping_company.required' => trans('messages.shipping_company.required'),
                    // 'shipping_charge.required' => trans('messages.shipping_charge.required'),
                ]
            );
        } else {

            $validator = Validator::make(
                $request->all(),
                array(
                    "order_id" => "required",
                    "product_array" => "required",
                    "receiver_id" => "required",
                    "shipping_company" => "required",
                    // "shipping_charge" => "required",
                ),
                [
                    'order_id.required' => trans('messages.order_id.required'),
                    'product_array.required' => trans('messages.product_id.required'),
                    'receiver_id.required' => trans('messages.receiver_id.required'),
                    'shipping_company.required' => trans('messages.shipping_company.required'),
                    // 'shipping_charge.required' => trans('messages.shipping_charge.required'),
                ]
            );
        }
        if ($validator->fails()) {
            $msg = $validator->errors()->getMessages();
            $ms = "Validation error";
            foreach ($msg as $key => $value) {
                $ms = $value[0];
            }
            return response::json(['success' => false, 'message' => $ms, "code" => 400], 400);
        }
        $productarray = json_decode($request->product_array, true);
        $shippingCharge = 0;
        // dd(collect($productarray)->groupBy('seller_id'));
        // $address = Agentreceiver::where('id', $request->receiver_id)->first();
        // dd($address);
        // dd($shippingCharge);

        $order = Order::where('id', $request->order_id)->where('status', "pending")->first();
        $discount = 0;
        if (count($order) > 0) {
            $old_order = Order::with('orderProduct')->with('orderAddress')->where('id', $request->order_id)->first();
            $history = new Oldorderhistory;
            $history->order_id = $request->order_id;
            $history->change_order_on = date('Y-m-d H:i:s');
            $history->old_order_details = $old_order;
            $history->save();
            // $order->courier_company_name = ($request->shipping_company != "") ? $request->shipping_company : 0;
            $order->receiver_id = $request->receiver_id;
            // $order->shipping_charge = $shippingCharge;
            $order->discount = 0;
            $order->coupon_id = 0;

            $order->save();

            $shippingcomapanies = json_decode($request->shipping_company);
            $shippingCompany = ShippingCompany::where('id', $request->shipping_company)->first();
            //if (count($shippingCompany) > 0) {
            /** For Delivery */
            //if ($shippingCompany->slug != "self-collect") {
            if ($order->role_id < 7) {
                $address = Agentreceiver::where('id', $request->receiver_id)->first();
                $orderaddress = OrderAddress::where('order_id', $request->order_id)->first();
                $orderaddress->name = $address->name;
                $orderaddress->contact_number = $address->contact_no;
                $orderaddress->address_line1 = $address->address_line1;
                $orderaddress->address_line2 = $address->address_line2;
                $orderaddress->state = $address->state;
                $orderaddress->town = $address->town;
                $orderaddress->country_code = $address->countrycode;
                $orderaddress->postal_code = $address->postal_code;
                $orderaddress->country = $address->country;
                $orderaddress->self_pickup_address = null;
                $orderaddress->save();
            } else {
                $address = Staffreceiver::where('id', $request->receiver_id)->first();
                $orderaddress = OrderAddress::where('order_id', $request->order_id)->first();
                $orderaddress->name = $address->name;
                $orderaddress->contact_number = $address->contact_no;
                $orderaddress->address_line1 = $address->address_line1;
                $orderaddress->address_line2 = $address->address_line2;
                $orderaddress->state = $address->state;
                $orderaddress->town = $address->town;
                $orderaddress->country_code = $address->countrycode;
                $orderaddress->postal_code = $address->postal_code;
                $orderaddress->country = $address->country;
                $orderaddress->self_pickup_address = null;
                $orderaddress->save();
            }

            $shippingmethod = $this->getShippingChargeUpdated($address, 0, $user, collect($productarray)->groupBy('seller_id'), $shippingcomapanies);
            if (!$shippingmethod || !isset($shippingmethod[0][0])) {
                return response::json(['success' => false, 'message' => 'Shipping method not available!', "code" => 500], 500);
            }
            //dd($shippingmethod[0][0]);
            $shippingChargeActual = 0;
            $shippingAgent = 0;
            $shippingCharge = array_sum(array_column($shippingmethod[0][0], 'price'));
            $shippingChargeActual = array_sum(array_column($shippingmethod[0][0], 'actual_price'));
            $shippingAgent = array_sum(array_column($shippingmethod[0][0], 'agent_price'));

            $order->shipping_charge = $shippingCharge;
            $order->shipping_details = json_encode($shippingmethod);
            foreach ($shippingmethod[0][0] as $company) {
                $value = $company;

                $order->counriercompanies()->where(['seller_id' => $value['seller_id']])->update(['seller_id' => $value['seller_id'], 'price' => $value['price'], 'shipping_company' => $value['shipping_company'], 'detail' => json_encode($value)]);
            }
            $order->save();
            if ($shippingChargeActual > $shippingCharge) {
                if ($user->parent && $user->parent->role_id < 7) {
                    $order->update(['shipping_paid_by_agent' => ($shippingAgent)]);
                } else {
                    $order->update(['shipping_paid_by_company' => ($shippingChargeActual - $shippingCharge)]);

                }
            }
            $order->tracking_no()->delete();

            foreach ($shippingmethod[0][0] as $key => $shipping) {
                if ($shipping['tracking_number'] > 1) {
                    for ($i = 0; $i < $shipping['tracking_number']; $i++) {
                        $order->tracking_no()->create(['seller_id' => $key, 'price' => $shipping['price'], 'tracking_number' => '']);
                    }
                } else {
                    $order->tracking_no()->create(['seller_id' => $key, 'price' => $shipping['price'], 'tracking_number' => '']);
                }
            }
        } else {
            /** SELF COLLECT */
            $selfCollect = ShippingCompany::where('slug', 'self-collect')->first();
            if ($selfCollect != null) {
                $orderaddress = OrderAddress::where('order_id', $request->order_id)->first();

                $orderaddress->self_pickup_address = $selfCollect->address;
                $orderaddress->save();
            }
        }
        //}

        if ($request->payment_method == 3 || $order->order_type == 2) {
            $totalamount = 0;
        } else {
            $totalamount = $shippingCharge;
        }

        $orderTotalAmount = 0;
        foreach ($productarray as $product_detail) {
            $orderprouct = OrderProduct::where('order_id', $request->order_id)->where('product_id', $product_detail['product_id'])->first();
            $oldqty = $orderprouct->qty;
            $product = Product::where('id', $product_detail['product_id'])->first();
            if (isset($product_detail['variation_id'])) {
                if ($order->order_type == 1) {
                    $amount = $product->get_product_price($user, $product_detail['product_id'], $product_detail['variation_id']);
                } else {
                    $amount = $product->getcustomerproductprice($user, $product_detail['product_id'], $product_detail['qty'], $product_detail['variation_id']);
                }
            } else {
                if ($order->order_type == 1) {
                    $amount = $product->get_product_price($user, $product_detail['product_id']);
                } else {
                    $amount = $product->getcustomerproductprice($user, $product_detail['product_id'], $product_detail['qty']);
                }
            }

            $qtyamount = $amount * $product_detail['qty'];
            if ($request->coupon_id) {
                $today = Carbon::today()->format('Y-m-d');
                $coup = Coupon::where('id', $request->coupon_id)
                    ->whereHas('couponproduct', function ($query) use ($product_detail) {
                        $query->where('product_id', $product_detail['product_id']);
                    })->first();

                if ($coup) {
                    $coupon = Coupon::where('id', $request->coupon_id)
                        ->whereHas('couponproduct', function ($query) use ($product_detail) {
                            $query->where('product_id', $product_detail['product_id']);
                        })
                        ->where('total_qty', '>', 0)
                        ->whereDate('expiry_date', '>=', $today)
                        ->first();
                    if (!$coupon) {
                        return response::json(['success' => false, 'message' => 'Sorry! coupon not available.', "code" => 400], 400);
                    }

                    $usage = CouponReport::where('coupon_id', $coupon->id)
                        ->where('user_id', $user->id)
                        ->count();
                    if ($usage >= $coupon->usage_per_user) {
                        return response::json(['success' => false, 'message' => 'You have already used this coupon.', "code" => 400], 400);
                    }
                    $products = $coupon->couponproduct->pluck('product_id')->toArray();
                    if (in_array($product_detail['product_id'], $products)) {
                        $product = Product::where('id', $product_detail['product_id'])->first();
                        $amount = $product->getcustomerproductprice($user, $product_detail['product_id'], $product_detail['qty'], $product_detail['variation_id']);

                        $qtyamount = $amount * $product_detail['qty'];
                        if ($coupon->discount_type == 'percent') {
                            // if($coupon->usage_per_user > 1){
                            //     $discount = ($coupon->discount * $qtyamount) / 100;

                            // }else{
                            $discount = ($coupon->discount * $amount) / 100;

                            // }
                        } else {
                            $discount = $coupon->discount;
                        }
                    }
                    if ($discount > 0) {
                        $coupon = Coupon::where('id', $request->coupon_id)
                            ->whereHas('couponproduct', function ($query) use ($product_detail) {
                                $query->where('product_id', $product_detail['product_id']);
                            })
                            ->first();
                        $products = $coupon->couponproduct->pluck('product_id')->toArray();
                        if (in_array($product_detail['product_id'], $products)) {
                            $coupon->decrement('total_qty', 1);
                            CouponReport::create(['coupon_id' => $coupon->id,
                                'user_id' => $user->id,
                                'product_id' => $product_detail['product_id'],
                                'order_id' => $order->id,
                                'redeemed_date' => Carbon::now(),
                            ]);
                            $orderprouct->update(['discount' => $discount]);

                        }
                        $order->discount = $discount;
                        $order->coupon_id = $request->coupon_id;
                        $order->save();
                    }
                }
            }
            // echo $discount;die();
            $totalamount = $totalamount + $qtyamount;
            $orderTotalAmount = $orderTotalAmount + $qtyamount - $discount;
            $orderprouct->qty = $product_detail['qty'];
            $orderprouct->price = $amount;
            $orderprouct->product_info = json_encode($product);
            $orderprouct->save();

            // add qty for a product because qty is decrese only
            $addedqty = $oldqty - $product_detail['qty'];
            $product->qty = $product->qty + $addedqty;
            $product->save();
        }
        $totalamount = round($totalamount);
        if ($order->payment_by == 3) {
            $oldhistory = transactionhistoriesagent::where('order_id', $request->order_id)->where('transaction_for', "payment")->first();
            $oldamount = $oldhistory->amount;

            $oldamount = str_replace('-', '', $oldamount);
            if ((float) $oldamount > (float) $totalamount) {
                $diffamount = $oldamount - $totalamount;
                $userwallet = User::where('id', $order->user_id)->first();
                $userwallet->wallet_amount = $userwallet->wallet_amount + $diffamount;
                $userwallet->save();
                if ($order->role_id == 15) {
                    Transactionhistoriesstaff::create([
                        'order_id' => $order->id,
                        'user_id' => $order->user_id,
                        'status' => 'accept',
                        'transaction_for' => 'refund',
                        'transaction_id' => time(),
                        'amount' => $diffamount,
                        'payment_by' => null,
                        'wallet_id' => '1',
                        'comment' => "Refund",
                    ]);
                } else {
                    Transactionhistoriesagent::create([
                        'order_id' => $order->id,
                        'user_id' => $order->user_id,
                        'status' => 'accept',
                        'transaction_for' => 'refund',
                        'transaction_id' => time(),
                        'amount' => $diffamount,
                        'payment_by' => null,
                        'wallet_id' => '1',
                        'comment' => "Refund",
                    ]);
                }

            }
        }
        if ($order->role_id == 15) {
            $transhistory = transactionhistoriesstaff::where('user_id', $request->order_id)->where('transaction_for', "payment")->first();

        } else {

            $transhistory = transactionhistoriesagent::where('order_id', $request->order_id)->where('transaction_for', "payment")->first();
        }
        if ($transhistory) {
            $transhistory->amount = $totalamount;
            $transhistory->save();
        }

        if ($request->payment_method == 3 && $order->order_type != 2) {
            $totalamount = $totalamount + $shippingCharge;
        }
        $totalamount = $totalamount - $discount;
/*$order->total_amount = $totalamount;*/
        $order->total_amount = $orderTotalAmount;
        $order->save();
        return response::json(['success' => true, "payload" => array("order_id" => $order->id, "totalamount" => $totalamount), 'message' => trans('messages.orderupdated'), "code" => 200], 200);
        /* } else {
    return response::json(['success' => false, 'message' => 'order not found', "code" => 400], 400);
    }*/
    }

    /* view cart */
    public function getCartShippingCompanies(Request $request)
    {
        $local = ($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'en';
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response::json(['success' => false, 'message' => 'Token not found', "code" => 302], 302);
        }

        // $cart = Cart::wherehas('productdetails', function ($query) {
        //                     $query->where('is_deleted', '0')
        //                     ->where('status', "active");
        //                 })->with('variation')
        //                 ->where('user_id', $user->id)
        //                 ->get()
        //                 ->map(function($item){
        //                     $item->variation_value = $item->variation;
        //                     unset($item->variation);
        //                     return $item;
        //                 })->groupBy('seller_id');
        $bankaccountdetails = Bankdetail::where('user_id', 1)->get();

        $agentreceiverdetails = User::select('id', 'address_line1', 'address_line2', 'state', 'town', 'postal_code', 'country')
            ->where('id', $user->id)
            ->first();

        if ($user->role_id == 15) {
            $address = Staffreceiver::where('staff_id', $user->id)->where('id', $request->address_id)->first();

        } elseif ($user->role_id == 7) {
            $address = UserAddress::where('user_id', $user->id)->where('id', $request->address_id)
                ->first();
        } else {
            $address = Agentreceiver::where('agent_id', $user->id)
                ->where('id', $request->address_id)
                ->first();
        }
        $receiveraddress = $address;
        $cart = json_decode($request->product_array);
        //dd(count($cart));
        if (count($cart) != 0) {
            $amount = 0;
            $customer_amount = 0;
            $response = [];
            $state = State::where('name', $address->state)->first();
            // dd($state);

            foreach ($cart as $key => $item) {
                $seller = Seller::where('name', $item->seller_name)->first();
                $weight = 0;
                $volume = 0;
                $result = [];
                $result['seller_id'] = $seller->id;
                $result['seller_name'] = $item->seller_name;

                foreach ($item->products as $cart_item) {

                    $product = Product::find($cart_item->product_id);
                    // dd($cart_item);
                    $product->image = $product->image();
                    $product_amount = $product->get_product_price($user, $product->id, $cart_item->variation_id);
                    $product_amount = $product_amount * $cart_item->qty;
                    $amount = $amount + $product_amount;
                    $product->name = $product->printproductname($local, $product->id);

                    if ($user->role_id == 7) {
                        $product->customer_price = $product->getcustomerproductprice($user, $product->id, $cart_item->qty, $cart_item->variation_id);
                    } else if ($user->role_id == 15) {
                        $product->staff_price = $product->getstaffproductprice($user, $product->id, $cart_item->qty, $cart_item->variation_id);
                        $product->customer_price = $product->getcustomerproductprice(null, $product->id, $cart_item->qty, $cart_item->variation_id);
                    } else {
                        $product->customer_price = $product->getcustomerproductprice(null, $product->id, $cart_item->qty, $cart_item->variation_id);
                    }

                    $customer_total = $product->customer_price * $cart_item->qty;
                    $customer_amount = $customer_amount + $customer_total;
                    $product = Product::find($cart_item->product_id);
                    $product->cod = ($product->cod) ? 1 : 0;
                    $cart_item->cod = ($product->cod) ? 1 : 0;
                    /*  if($product->free_shipping == '0'){
                    $product_weight = $product->weight * $cart_item->qty;
                    $weight +=  $product_weight;
                    $volume += ($product->height * $product->width * $product->length);
                    }*/

                    if (isset($request->order_id)) {
                        $productarr['id'] = $cart_item->product_id;
                        $productarr['name'] = $cart_item->product_price;
                        $productarr['qty'] = $cart_item->qty;
                        $productarr['name'] = $cart_item->product_name;
                        $productarr['product_id'] = $cart_item->product_id;
                        $orderproduct = OrderProduct::where('order_id', $request->order_id)->where('product_id', $cart_item->product_id)->first();
                        $orderproduct = json_decode($orderproduct->product_info);
                        $product_info = ["customer_price" => $orderproduct->customer_price,
                            "diamond_leader_price" => $orderproduct->diamond_leader_price,
                            "executive_leader_price" => $orderproduct->executive_leader_price,
                            "gold_leader_price" => $orderproduct->gold_leader_price,
                            "id" => $orderproduct->id,
                            "image" => $product->image(),
                            "name" => $orderproduct->name,
                            "plat_leader_price" => $orderproduct->plat_leader_price,
                            "silver_leader_price" => $orderproduct->silver_leader_price,
                            "staff_price" => $orderproduct->staff_price];
                        $productarr['productdetails'] = $product_info;
                        $result['products'][] = $productarr;
                        if ($product->free_shipping == '0') {
                            if ($cart_item->variation_id && $cart_item->variation_id != 0) {
                                $product_weight = $cart_item->variation->weight * $cart_item->qty;
                                $weight += $product_weight;
                                $volume += ($cart_item->variation->height * $cart_item->variation->width * $cart_item->variation->length) * $cart_item->qty;
                            } else {
                                $product_weight = $product->weight * $cart_item->qty;
                                $weight += $product_weight;
                                $volume += ($product->height * $product->width * $product->length) * $cart_item->qty;
                            }
                        }
                    } else {
                        $result['products'][] = $cart_item;
                        if ($product->free_shipping == '0') {
                            if ($cart_item->variation_id && $cart_item->variation_id != 0) {
                                $product_weight = $cart_item->variation_value->weight * $cart_item->qty;
                                $weight += $product_weight;
                                $volume += ($cart_item->variation_value->height * $cart_item->variation_value->width * $cart_item->variation_value->length) * $cart_item->qty;
                            } else {
                                $product_weight = $product->weight * $cart_item->qty;
                                $weight += $product_weight;
                                $volume += ($product->height * $product->width * $product->length) * $cart_item->qty;
                            }
                        }

                    }

                }

                $result['shipping_companies'] = ShippingCompany::whereHas('shippingcompanyseller', function ($query) use ($seller, $state) {
                    $query->where('state_id', $state->id)->where('seller_id', $seller->id);
                })
                    ->select('id', 'name', 'slug')
                    ->get()
                    ->map(function ($item) use ($weight, $state, $volume, $seller) {
                        $item->shippingcompanyseller = ShippingCompanySeller::where('state_id', $state->id)->where('seller_id', $seller->id)->get();
                        if ($weight > 0) {
                            $item->price = $item->getShippingPrice($weight, $state, $volume, $item);
                        } else {
                            $item->price = 0;
                        }
                        unset($item->shippingcompanyseller);
                        return $item;
                    });
                $response[] = $result;
            }

            $cart['sub_total'] = $amount;
            $cart['customer_amount'] = $customer_amount;

            return Response::json(["success" => true, "payload" => array("cart" => $response, "amount" => round($amount, 2), 'bankdetails' => $bankaccountdetails, "customer_amount" => round($customer_amount, 2)),
                "message" => trans('messages.cartproduct'), "code" => 200], 200);
        } else {
            return Response::json(["success" => true, "payload" => array("cart" => $cart), "message" => trans('messages.cartproduct'), "code" => 200], 200);
        }
    }

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

        $voucherData = Helper::getVoucherData($couponId, $request->cart_value, $request->product_array);
        $discount = $voucherData['discount'];
        $cashback = $voucherData['cashback'];
        $product_name = $voucherData['product'];
        $coupon = Voucher::where('id', (int) $couponId)->where('min_basket_price', '<=', $request->cart_value)->first();
        if($coupon && $discount > 0){            
            return response::json(['success' => true, 'discount' => $discount, 'coupon' => $coupon, 'product_name' => $product_name,"code" => 200], 200);
        }
        if($coupon && $cashback > 0){            
            return response::json(['success' => true, 'cashback' => $cashback, 'coupon' => $coupon, 'product_name' => $product_name,"code" => 200], 200);
        }
        return response::json(['success' => false, 'discount' => 0, "code" => 200], 200);
    }

    public function getSellerVoucher(Request $request){
        $sellerID = $request->sellerId;
        $voucherID = $request->voucherId;
        $subTotal = $request->subTotal;

        $seller = Seller::with(['vouchers' => function($q) use($subTotal) {
            $q->where('min_basket_price', '<=', $subTotal);
        }])->find($sellerID);                              

        if($seller && $seller->vouchers && count($seller->vouchers) > 0){
            $returnHTML = view('frontend.sellervoucher')->with('seller', $seller)->with('voucherID', $voucherID)->render();
            return response()->json(array('success' => true, 'html'=>$returnHTML));
        }
    }

    public function setSellerVoucher(Request $request){
        $sellerId = $request->seller_id;
        $voucherId = $request->voucher_id;
        $subTotal = $request->sub_total;
        $voucher = Voucher::where('seller_id', $sellerId)->where('id', $voucherId)->first();
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

    public function checkCoin(Request $request){
        $total = $request->total;
        $coinBalance = Auth::user()->coin_balance;
        $coinManagement = CoinManagement::first();
        $claimCoins = 0;

        if($coinManagement &&  ($total >= $coinManagement->min_order_amount) ){
            if($coinBalance >= $coinManagement->max_use_coin_per_order){
                $claimCoins = ($total * $coinManagement->coin_to_rm);
            }else{
                $claimCoins = ($total * $coinBalance);
            }
        }
        return response::json(['success' => true, 'claimCoins' => $claimCoins, "code" => 200], 200);
    }

    public function getProductVoucher(Request $request){
        $vouchersofProducts = VoucherProduct::whereIn('product_id', $request->productArray)->get()->groupBy('voucher_id')->toArray();

        $voucherIds = [];
        $productVouchers = [];
        if (count($vouchersofProducts) > 0) {
            $voucherIds = array_keys($vouchersofProducts);
            $productVouchers = Voucher::with('products:id,voucher_id,product_id')
                                        ->whereIn('id', $voucherIds)
                                        ->where('usage_qty', '>', 0)->where('type', 'product')->whereDate('to_date', '>', now())->get();
        }

        if($productVouchers && $productVouchers && count($productVouchers) > 0){
            $returnHTML = view('frontend.productvoucher')->with('productVouchers', $productVouchers)->render();
            return response()->json(array('success' => true, 'html'=>$returnHTML));
        }
    }

    public function getProductVoucherInCheckout(Request $request){
        $productsIds = array_column($request->productArray, 'product_id');
        $vouchersofProducts = VoucherProduct::whereIn('product_id', $productsIds)->get()->groupBy('voucher_id')->toArray();

        $voucherIds = [];
        $productVouchers = [];
        if (count($vouchersofProducts) > 0) {
            $voucherIds = array_keys($vouchersofProducts);
            $productVouchers = Voucher::with('products:id,voucher_id,product_id')->whereIn('id', $voucherIds)
                                ->where('usage_qty', '>', 0)->where('type', 'product')->whereDate('to_date', '>', now())->get();
        }

        $voucherID = $request->voucherId;
        if($productVouchers && $productVouchers && count($productVouchers) > 0){
            $returnHTML = view('frontend.checkoutproductvoucher')->with('productVouchers', $productVouchers)->with('voucherID', $voucherID)->render();
            return response()->json(array('success' => true, 'html'=>$returnHTML));
        }
    }
}
