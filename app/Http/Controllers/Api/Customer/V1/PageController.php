<?php

namespace App\Http\Controllers\Api\Customer\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Banner;
use App\ShockingsaleProduct;
use App\ProductCategory;
use App\Promotion;
use App\Product;
use Auth;
use App\DisplayCategory;
use App\SearchKeyword;
use App\BundleDeal;
use App\Seller;
use App\AttributeVariationPrice;
use Validator,Response, JWTAuth;

class PageController extends Controller
{
    public function __construct(){
        $this->user = null;
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
        // if (!$user = JWTAuth::parseToken()->authenticate()) {
        //     return response::json(['success' => false, 'message' => 'Token not found', "code" => 302], 302);
        // }
    }

    /* home screen */
    public function home(Request $request){
        /* top banners */
        $data['top_banners'] = Banner::with('bannerImages')->whereHas('bannerType', function($q){
                            $q->where('name', '=', 'Top Banner');
                        })->where('status', '=', 'active')->first();

        /* wallet balance */
        $data['wallets'] = ['wallet_amount' => 0, 'coin_balance' => 0, 'vouchers' => 0];

        if ($request->header('Authorization')){
            if ($user = JWTAuth::parseToken()->authenticate()) {
                $data['wallets'] = ['wallet_amount' => $user->wallet_amount, 'coin_balance' => ($user->coin_balance) ? $user->coin_balance:0, 'vouchers' => $user->vouchers->count()];
            }
        }
        // if($this->user){
        //     $data['wallets'] = ['wallet_amount' => $this->user->wallet_amount, 'coin_balance' => ($this->user->coin_balance) ? $this->user->coin_balance:0, 'vouchers' => $this->user->vouchers->count()];
        // }

        /* category */
        $data['categories'] = Category::with('image')
                                ->whereHas('allproducts')
                                ->where('is_deleted', '=', '0')
                                ->where('status','active')
                                ->select('id','name','slug','status')
                                ->orderBy('id', 'DESC')
                                ->get()
                                ->map(function($item){
                                    $item->products = Product::whereHas('categories',function($q) use ($item){
                                        $q->where('category_id',$item->id);
                                    })->with('seller')->with('variation')->with('image')->limit('12')->get();
                                    return $item;
                                });

        /* main banners with title */
        $data['main_banners'] = Banner::with('bannerImages')->whereHas('bannerType', function($q){
                            $q->where('name', '=', 'Main Banner');
                        })->where('status', '=', 'active')->first();

        /* mod banner */
        $data['sockingsale_banners'] = Banner::with('bannerImages')->whereHas('bannerType', function($q){
                            $q->where('name', '=', 'Mid Banner')
                            ->orWhere('name', '=', 'Small Banner');
                        })->where('status', '=', 'active')->first();

        /* socking sale */
        $data['sockingSale'] = ShockingsaleProduct::where('start_date', '<=', date('Y-m-d H:i:s'))
                                    ->where('end_date', '>=', date('Y-m-d H:i:s'))
                                    ->where('status','active')
                                    ->whereHas('product')
                                    ->with(['product'=>function($query){
                                        $query->with('seller')->with('variation')->with('image');
                                    }])
                                    ->orderBy('start_date','asc')
                                    ->get()->filter(function ($product, $key) {
                                        return ($product->percent_archived['sold'] < $product->goal);
                                    })->values();

        /* promotions */
        $data['promotions'] = Promotion::orderBy('id','desc')->take(6)->get();

        /* category section with banners */
        $data['display_categories'] = DisplayCategory::with('displayCategoryBanners')
                                    ->with(['displayCategoryProducts'=>function($query){
                                        $query->with(['product'=>function($query){
                                            $query->with('seller')->with('variation')->with('image');
                                        }]);
                                    }])
                                    ->whereHas('displayCategoryProducts')
                                    ->where('display_on_homescreen', '1')
                                    ->where('status', 'active')
                                    ->orderBy('sequence', 'asc')
                                    ->get();

        /* search */
        $data['search']['keywords'] = $keywords = SearchKeyword::where('category', NULL)->orderBy('times', 'DESC')->limit(10)->get();
        
        $data['search']['searched_categories'] = $searchedCategories = SearchKeyword::with(['getCategory'=> function($query){
                                $query->with('image');
                            }])->where('category', '!=' , NULL)
                            ->orderBy('times', 'DESC')
                            ->limit(4)->get();

        $listOfKeywords   =  $keywords->pluck('keyword');
        $listOfCategories =  $searchedCategories->pluck('category'); 

        $data['search']['products_keywords'] = Product::with('seller')->with('variation')->where(function ($query) use($listOfKeywords,$listOfCategories) {
                                            for ($i = 0; $i < count($listOfKeywords); $i++){
                                               $query->orwhere('name', 'like',  '%' . $listOfKeywords[$i] .'%');
                                            }      
                                            $query->orWhereHas('categories.category', function($query) use ($listOfCategories) {
                                                    for ($i = 0; $i < count($listOfCategories); $i++){
                                                        $query->orwhere('categories.name', 'like',  '%' . $listOfCategories[$i] .'%');
                                                    } 
                                                });
                                       })
                                        ->with('seller')->with('variation')->with('image')
                                        ->where('is_deleted', '0')
                                        ->where('status', "active")
                                        ->limit(16)
                                        ->get();

        /* last banners */
        $data['last_banners'] =  Banner::with('bannerImages')
                                            ->whereHas('bannerType', function($q){
                                                $q->where('name', '=', 'Last Banner');
                                            })->where('status', '=', 'active')->first();

        return response()->json(['success' => true, 'data' => $data, 'message' => 'Data retrived successfully.', 'code' => 200], 200);

    }

    /* search screen */
    public function search(Request $request){
        $data['categories'] = Category::whereHas('allproducts')
                                        ->where('is_deleted', '=', '0')
                                        ->where('status','active')
                                        ->orderBy('id', 'DESC')
                                        ->get();

        $data['brands']     = Seller::has('products')->orderBy('id', 'DESC')->get();
        $data['brandimage'] = asset('assets/images/adidas-logo.png');

        $products   = Product::with('images')
                                        ->with('seller')->with('variation')->with('reviews')
                                        ->with('categories.category')
                                        ->where('is_deleted', '0')
                                        ->where('status', "active");

        $searchData = ($request->has('search') && $request->search != '') ? $request->search : '';
        if ($request->has('search')) {
            $products = $products->where(function ($q) use ($searchData){
                    $q->where('products.name', 'like', '%' . $searchData . '%');
                    $q->orWhereHas('categories.category', function($q1) use ($searchData) {
                        $q1->where('categories.name', 'like', '%' . $searchData . '%')
                            ->orWhere('categories.slug', 'like', '%' . $searchData . '%');
                    });
                    $q->orWhereHas('seller', function($q1) use ($searchData) {
                        $q1->where('sellers.name', 'like', '%' . $searchData . '%');
                    });
                });
        }

        if ($request->has('min_price') || $request->has('max_price') ) {
            $minPrice = $request->min_price;
            $maxPrice = $request->max_price;
            $products = $products->whereBetween('customer_price', [$minPrice, $maxPrice]);
        }

        if ($request->has('brands')) {
            $products = $products->whereIn('seller_id', $request->brands);
        }

        if ($request->has('categories')) {
            $categoriesIds = $request->categories;
            $products = $products->whereHas(
                'categories', function ($query) use ($categoriesIds) {
                    $query->whereIn('category_id', $categoriesIds);
                }
            );
        }

        $products = $products->where('is_deleted', '0')->where('status', "active")
                        ->orderBy('id', 'DESC')->paginate(12);

        $data['products']['last_page'] = $products->lastPage();
        $data['products']['current_page'] = $products->currentPage();

        $data['products']['data'] = $products->values();
        return response()->json(['success' => true, 'data' => $data, 'message' => 'Data retrived successfully.', 'code' => 200], 200);

    }

    public function getSearchfilter(Request $request)
    {
        $data['categories'] = Category::whereHas('allproducts')
                                        ->where('is_deleted', '=', '0')
                                        ->where('status','active')
                                        ->orderBy('id', 'DESC')
                                        ->get();

        $data['brands']     = Seller::has('products')->orderBy('id', 'DESC')->get();
        $data['brandimage'] = asset('assets/images/adidas-logo.png');

        return response()->json(['success' => true, 'data' => $data, 'message' => 'Data retrived successfully.', 'code' => 200], 200);
    }

    /* product detail */
    public function productDetail(Request $request){
        $data['product'] = $product = Product::where('is_deleted', '0')
                                        ->where('status', "active")
                                        ->with(['attributes'=>function($query){
                                            $query->with('variations');
                                        }])
                                        ->with('shockingsale')
                                        ->with('images')
                                        ->with('seller')
                                        ->with('reviews')
                                        ->with('reviews.user:id,name,image')
                                        ->with('reviews.reviewRatingImages')
                                        ->with('reviews.reviewRatingVotes')
                                        ->where('id', $request->product_id)
                                        ->select('id','seller_id', 'name', 'description', 'is_new', 'qty','photos_zip_file','video','cod','video_thumb','tag','type','is_variation','customer_price','sell_price')
                                        ->orderBy('id', 'DESC')->first();
        if(!$product){
            return response::json(['success' => false, 'message' => 'Product not found!', "code" => 400], 400);
        }
        $data['seller'] = $product->seller;
        $data['seller_total_products']  = $product->seller->products->count();
        $data['seller_total_followers'] = $product->seller->followers->count();
        unset($data['seller']->products);
        unset($data['seller']->followers);
        unset($product->seller);

        /* realted category products */
        $categories = $product->categories->pluck('category_id');
        if (count($categories) > 0) {
            $data['same_category_products'] = Product::whereHas('categories', function ($query) use ($categories) {
                                            $query->where('category_id', $categories);
                                        })->where('is_deleted', '=', '0')
                                        ->inRandomOrder()
                                        ->limit(12)
                                        ->get();
        } else {
            $data['same_category_products'] = Product::where('name', 'like', '%' . $product->name . '%')->where('is_deleted', "0")
                                        ->where('status', "active")->where('is_deleted', '=', '0')->inRandomOrder()->limit(8)->get();
        }

        /* same seller products */
        $data['same_seller_products'] = Product::whereHas('categories')
                                        ->where('seller_id', $product->seller_id)
                                        ->where('is_deleted', "0")
                                        ->where('status', "active")
                                        ->where('is_deleted', '=', '0')
                                        ->inRandomOrder()
                                        ->limit(4)
                                        ->get();

        /* social share */
        // $share = new Share();
        // $sociallinks = $share->page(route('productDetail',$product->slug), $product->name)
        //                     ->messanger()
        //                     ->facebook()
        //                     ->telegram()
        //                     ->whatsapp()
        //                     ->twitter()
        //                     ->getRawLinks();

        /* bundle deals */
        $productId = $product->id;
        $data['bundle_deal'] = $bundleDeal = BundleDeal::with('BundleDealProducts.product')
                                                ->whereHas('BundleDealProducts', function ($query) use ($productId) {
                                                    return $query->where('product_id', $productId);
                                                })
                                                ->where('status', 'active')
                                                ->orderBy('discount', 'DESC')->first();
                        
        $bundleDealProducts = [];
        if($bundleDeal && $bundleDeal->BundleDealProducts && count($bundleDeal->BundleDealProducts) > 0){
            $bundleDealProducts = $bundleDeal->BundleDealProducts;
        }
        return response()->json(['success' => true, 'data' => $data, 'message' => 'Data retrived successfully.', 'code' => 200], 200);
    }

    /* product variations */
    public function productVariations(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                "product_id" => "required",
                "product_variation_id" => "required|array",
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
        $prices = AttributeVariationPrice::where('product_id',$request->product_id)
                                            ->get()
                                            ->filter(function ($variation, $key) use ($request){
                                                return !array_diff($variation->variation_value, $request->product_variation_id);
                                            })->values();

        return Response::json(["success" => true, "payload" => array("product" => $prices), "message" => "Variation get successfully", "code" => 200], 200);
    }
}
