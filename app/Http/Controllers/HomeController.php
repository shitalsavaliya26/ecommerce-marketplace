<?php

namespace App\Http\Controllers;

use App\AttributeVariationPrice;
use App\Banner;
use App\User;
use App\SellerFollower;
use App\Category;
use App\ContactUs;
use App\SellerTopBanner;
use App\SellerLastBanner;
use App\State;
use App\Helpers\Helper;
use App\Product;
use App\DisplayCategory;
use App\ReviewRating;
use App\SearchKeyword;
use App\ReviewRatingVote;
use App\ShopCategory;
use App\ShopDecoration;
use App\Seller;
use App\CmsPage;
use App\BundleDeal;
use App\BundleDealProduct;
use App\PushNotification;
use Illuminate\Http\Request;
use Validator;
use App\Helpers\Share;
use App\Promotion;
use App\ShockingsaleProduct;
use App\Shockingsale;
use DB,Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('images')
                            ->whereHas('allproducts')
                            ->with(['allproducts' => function ($query) {
                                return $query->limit(12);
                            }])
                            ->with('products.images')
                            ->where('is_deleted', '=', '0')
                            ->where('status', 'active')
                            ->orderBy('id', 'DESC')
                            ->get();

        $displayCategories = DisplayCategory::with('displayCategoryBanners')
                                    ->with('displayCategoryProducts.product')
                                    ->where('display_on_homescreen', '1')
                                    ->where('status', 'active')
                                    ->orderBy('sequence', 'asc')
                                    ->get();

        $keywords = SearchKeyword::where('category', NULL)->orderBy('times', 'DESC')->limit(10)->get();
        
        $searchedCategories = SearchKeyword::with('getCategory')->whereHas('getCategory')->where('category', '!=' , NULL)->orderBy('times', 'DESC')->limit(4)->get();

        $topBanners = Banner::with('bannerImages')->whereHas('bannerType', function($q){
                            $q->where('name', '=', 'Top Banner');
                        })->where('status', '=', 'active')->first();

        $mainBanners = Banner::with('bannerImages')->whereHas('bannerType', function($q){
                            $q->where('name', '=', 'Main Banner');
                        })->where('status', '=', 'active')->first();

        $midBanners = Banner::with('bannerImages')->whereHas('bannerType', function($q){
                            $q->where('name', '=', 'Mid Banner');
                        })->where('status', '=', 'active')->first();

        $smallBanners = Banner::with('bannerImages')->whereHas('bannerType', function($q){
                            $q->where('name', '=', 'Small Banner');
                        })->where('status', '=', 'active')->first();

        $lastBanners = Banner::with('bannerImages')->whereHas('bannerType', function($q){
                            $q->where('name', '=', 'Last Banner');
                        })->where('status', '=', 'active')->first();

        $listOfKeywords =  $keywords->pluck('keyword');
        $listOfCategories =  $searchedCategories->pluck('category'); 

        $productsOfKeywords = [];
        if(count($listOfKeywords) > 0 || count($listOfCategories) > 0 ){
            $productsOfKeywords = Product::where(function ($query) use($listOfKeywords,$listOfCategories) {
                                                for ($i = 0; $i < count($listOfKeywords); $i++){
                                                   $query->where('name', 'like',  '%' . $listOfKeywords[$i] .'%');
                                                }      
                                                $query->orWhereHas('categories.category', function($query) use ($listOfCategories) {
                                                        for ($i = 0; $i < count($listOfCategories); $i++){
                                                            $query->orwhere('categories.name', 'like',  '%' . $listOfCategories[$i] .'%');
                                                        } 
                                                    });
                                           })
                                            ->where('is_deleted', '0')
                                            ->where('status', "active")
                                            ->limit(18)
                                            ->get();
        }
                                        // dd(date('Y-m-d H:i:s'));
        $sockingSale = ShockingsaleProduct::where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))
        ->where('status','active')
        ->whereHas('product')
        ->orderBy('start_date','asc')->get()->filter(function ($product, $key) {
                    return ($product->percent_archived['sold'] < $product->goal);
                })->values();
        // if ($sockingSale->count() == 0) {
        //     $sockingSale = ShockingsaleProduct::where('start_date', '>=', date('Y-m-d').' 00:00:00'))->where('end_date', '<=', date('Y-m-d').' 00:00:00'))->orderBy('start_date','asc')->get();
        // }

        // $sockingSale = Product::where('is_deleted', '0')
        //                                 ->where('status', "active")
        //                                 ->limit(16)
        //                                 ->orderBy('id','desc')
        //                                 ->get();

        $promotions = Promotion::orderBy('id','desc')->take(6)->get();
        return view('home', compact('categories', 'topBanners', 'mainBanners', 'midBanners', 'smallBanners', 
                    'lastBanners', 'displayCategories', 'keywords', 'searchedCategories', 'productsOfKeywords','sockingSale','promotions'));
    }

    public function maxShopMall()
    {   
        return view('frontend.max-shop-mall');
    }

    /**
     * Display a listing of the request.
     *
     * @return \Illuminate\Http\Request
     */
    public function searchFilter(Request $request,$slug = null)
    {
        $categories = Category::whereHas('allproducts')
            ->where('is_deleted', '=', '0')
            ->where('status', 'active')
            ->where('parent_id', null)
            ->orderBy('id', 'DESC')->get();

        $brands = Seller::has('products')->orderBy('id', 'DESC')->get();

        $products = Product::with('images')->with('seller')->with('reviews')
            ->with('categories.category')->where('is_deleted', '=', '0')->where('status', "active");

        $searchData = ($request->has('search') && $request->search != '') ? $request->search : '';
        if (($request->has('search') && trim($request->search) != '' && $request->search != null) || $slug) {
            $products = $products->where(function ($q) use ($searchData,$slug){
                    $q->where('products.name', 'like', '%' . $searchData . '%');
                    $q->orWhereHas('categories.category', function($q1) use ($searchData,$slug) {
                        $q1->where('categories.name', 'like', '%' . $searchData . '%')
                            ->orWhere('categories.slug', 'like', '%' . $searchData . '%')
                            ->orWhere('categories.slug', 'like', '%' . $slug . '%');
                    });
                    $q->orWhereHas('seller', function($q1) use ($searchData) {
                        $q1->where('sellers.name', 'like', '%' . $searchData . '%');
                    });
                });
        }

        if ($request->has('searchParam')) {
            $products = $products->where(function ($q) use ($request){
                                $q->where('products.name', 'like', '%' . $request->searchParam['searchParam'] . '%');
                                $q->orWhereHas('categories.category', function($q1) use ($request) {
                                    $q1->where('categories.name', 'like', '%' . $request->searchParam['searchParam'] . '%')
                                        ->orWhere('categories.slug', 'like', '%' . $request->searchParam['searchParam'] . '%');
                                });
                            });
        }

        if ($request->has('prices') || $request->has('min_price') || $request->has('max_price') ) {
            $minPrice = $request->has('prices') ? $request->prices['min_price'] : $request->min_price;
            $maxPrice = $request->has('prices') ? $request->prices['max_price'] : $request->max_price;
            $products = $products->whereBetween('customer_price', [$minPrice, $maxPrice]);
        }

        if ($request->has('brands')) {
            $brandsIds = array_map('intval', $request->brands['brands']);
            $products = $products->whereIn('seller_id', $brandsIds);
        }

        if ($request->has('categories')) {
            $categoriesIds = array_map('intval', $request->categories['categories']);
            $categoryID = Category::select('id','parent_id')->whereIn('id', $categoriesIds)->with('subs:id,parent_id')->get()->toArray();
            $finalCatIds = $this->buildTree($categoryID);
            $products = $products->whereHas(
                'categories', function ($query) use ($finalCatIds) {
                    $query->whereIn('category_id', $finalCatIds);
                }
            );
        }

        $products = $products->where('is_deleted', '0')->where('status', "active")
                        ->orderBy('id', 'DESC')->paginate(50)->appends($request->all());
        if ($request->ajax()) {
            return view('frontend.search.table', compact('products'))->render();
        }
        return view('frontend.search.search-filter', compact('searchData', 'products', 'categories', 'brands', 'slug'));
    }

    /**
     * Display a listing of the request.
     *
     * @return \Illuminate\Http\Request
     */
    public function customerPrice($product_id)
    {
        $price = 0;
        $product = Product::find($product_id);
        if ($product_id != '' && $qty != '' && $qty != 0) {
            if (!$variation_id) {

                if ($qty == 1) {
                    $price = $product->customer_price;
                } else {
                    $daynamic_customer_price = Customerpricetier::where('product_id', $product->id)->where('qty', '<=', $qty)->orderBy('qty', "DESC")->first();
                    if (count($daynamic_customer_price) == 0) {
                        $price = $product->customer_price;
                    } else {
                        $price = $daynamic_customer_price->price;
                    }
                }
            } else {
                $result = AttributeVariationPrice::where('id', $variation_id)->first();
                $price = $result->customer_price;
            }
        }
        return $price;
    }

    public function showProduct($slug)
    {
        // $id = Helper::decrypt($request->id);

        $products = Category::with(['allproducts' => function ($query) {
            return $query->take(12);
        }])->where('is_deleted', '=', '0')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->orderBy('id', 'DESC')->first();

        $view = view('frontend.product')->with(compact('products'))->render();

        return response()->json([
            'status' => 200, 'view' => $view]
        );
    }
    /* category page */
    public function showCategory(Request $request,$slug)
    {
        // $id = Helper::decrypt($request->category);
        $products = Category::with(['allproducts'])->where('is_deleted', '=', '0')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->where('is_deleted', '=', '0')
            ->orderBy('id', 'DESC')->first();
            
        $view = view('frontend.product')->with(compact('products'))->render();

        return view('frontend.category', compact('products'));

    }

    /* product detail */
    public function productDetail($slug)
    {
        if(url()->previous() == route('login.phone') || url()->previous() == route('login')){
            // return redirect()->route('home');
        }

        $product = Product::where('is_deleted', '=', '0')
                        ->where('status', "active")
                        ->with('reviews')
                        ->with('reviews.user:id,name,image')
                        ->with('reviews.reviewRatingImages')
                        ->with('reviews.reviewRatingVotes')
                        ->where('slug', $slug)
                        ->orderBy('id', 'DESC')->first();
        if(!$product){
            abort(404);
        }

        $categories = $product->categories->pluck('category_id');
        if (count($categories) > 0) {
            $categoryProducts = Product::whereHas('categories', function ($query) use ($categories) {
                                            $query->where('category_id', $categories);
                                        })->where('is_deleted', '=', '0')
                                        ->inRandomOrder()
                                        ->limit(12)
                                        ->get();
        } else {
            $categoryProducts = Product::where('name', 'like', '%' . $product->name . '%')->where('is_deleted', "0")
                                        ->where('status', "active")->where('is_deleted', '=', '0')->inRandomOrder()->limit(8)->get();
        }
        $sameSellerProducts = Product::whereHas('categories')->where('seller_id', $product->seller_id)->where('is_deleted', "0")
                                        ->where('status', "active")->where('is_deleted', '=', '0')->inRandomOrder()->limit(4)->get();

        /* social share */
        $share = new Share();
        $sociallinks = $share->page(route('productDetail',$product->slug), $product->name)
                            ->messanger()
                            ->facebook()
                            ->telegram()
                            ->whatsapp()
                            ->twitter()
                            ->getRawLinks();
                            
        $productId = $product->id;
        $bundleDeal = BundleDeal::with('BundleDealProducts.product')
                        ->whereHas('BundleDealProducts', function ($query) use ($productId) {
                            return $query->where('product_id', $productId);
                        })
                        ->where('status', 'active')
                        ->orderBy('discount', 'DESC')->first();
                        
        $bundleDealProducts = [];
        if($bundleDeal && $bundleDeal->BundleDealProducts && count($bundleDeal->BundleDealProducts) > 0){
            $bundleDealProducts = $bundleDeal->BundleDealProducts;
        }
        $hours = 0;
        $mins = 0;
        $seconds = 0;
        // return $bundleDealProducts;
        return view('frontend.productdetail', compact('product', 'sameSellerProducts', 'categoryProducts','sociallinks', 'bundleDealProducts', 'bundleDeal'));
       
    }

    /* get varition price */
    public function getVariation(Request $request)
    {
        $product_id = Helper::decrypt($request->product_id);
        $validator = Validator::make(
            $request->all(),
            array(
                "product_id" => "required",
                "variation" => "required|array",
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
            \Session::flash('error', $ms);
            return redirect()->back();
        } else {
            $product = AttributeVariationPrice::where('product_id', $product_id)
                ->get()
                ->filter(function ($variation, $key) use ($request) {
                    return !array_diff($variation->variation_value, $request->variation);
                })->values();

            $productdetail = Product::where('is_deleted', '=', '0')
                ->where('id', $product_id)
                ->orderBy('id', 'DESC')->first();

            $view = view('frontend.variation')->with(compact('product', 'productdetail'))->render();

            return response()->json([
                'status' => 200, 'view' => $view]
            );
        }
        return view('frontend.variation', compact('product'));
    }

    public function submitVote(Request $request)
    {
        $checkReview = ReviewRatingVote::where('review_rating_id', $request->reviewId)
            ->where('user_id', $request->userId)->first();
        $userId = auth()->user() ? auth()->user()->id : null;
        if ($checkReview) {
            $checkReview->delete();
            $review = ReviewRating::with('reviewRatingVotes')->find($request->reviewId);
            $count = count($review->reviewRatingVotes);
            return response()->json(['success' => 'done', 'review_id' => $request->reviewId, 'status' => 'delete', 'count' => $count, 'user_id' => $userId]);
        } else {
            $reviewVote = new ReviewRatingVote();
            $reviewVote->review_rating_id = $request->reviewId;
            $reviewVote->user_id = $request->userId;
            $reviewVote->save();
            $review = ReviewRating::with('reviewRatingVotes')->find($request->reviewId);

            $count = count($review->reviewRatingVotes);
            return response()->json(['success' => 'done', 'review_id' => $request->reviewId, 'status' => 'add', 'count' => $count, 'user_id' => $userId]);
        }
    }

    public function filterReview(Request $request)
    {
        $filter = $request->filter;
        $product_id = Helper::decrypt($request->product_id);

        $reviews = ReviewRating::where('product_id', $product_id)
            ->with('reviewRatingImages')
            ->with('reviewRatingVotes');

        if ($filter == 'comment') {
            $reviews->whereNotNull('reply')->where('reply', '!=', '');
        } elseif ($filter == 'media') {
            $reviews->whereHas('reviewRatingImages');
        } elseif ($filter == 'all') {
            $reviews;
        } elseif ($filter == '5') {
            $reviews->where('rate', 5);
        } elseif ($filter == '4') {
            $reviews->where('rate', 4);
        } elseif ($filter == '3') {
            $reviews->where('rate', 3);
        } elseif ($filter == '2') {
            $reviews->where('rate', 2);
        } elseif ($filter == '1') {
            $reviews->where('rate', 1);
        }
        $reviews = $reviews->get();
        $view = view('frontend.review')->with(compact('reviews'))->render();

        return response()->json([
            'status' => 200, 'view' => $view]
        );
    }

    public function addKeyword(Request $request)
    {
        if($request->has('keyword') && $request->keyword != '' && $request->keyword != null){
            session()->put('search', $request->keyword);

            $keyword = $request->keyword;

            $searchCategory = Category::where('name', $keyword)->where('status', 'active')->orWhere('slug', $keyword)->first();
            if($searchCategory){
                $existance = SearchKeyword::where('category', $searchCategory->slug)->first();
                if($existance){
                    $existance->times = $existance->times + 1;
                    $existance->save();
                }else{
                    $searchKeyword = new SearchKeyword();
                    $searchKeyword->category_id = $searchCategory->id;
                    $searchKeyword->category = $searchCategory->slug;
                    $searchKeyword->times = 1;
                    $searchKeyword->save();
                }
            }else{
                $existance = SearchKeyword::where('keyword', $keyword)->first();
                if($existance){
                    $existance->times = $existance->times + 1;
                    $existance->save();
                }else{
                    $searchKeyword = new SearchKeyword();
                    $searchKeyword->keyword = $request->keyword;
                    $searchKeyword->times = 1;
                    $searchKeyword->save();
                }
            }
            return response()->json([
                'status' => 200]
            );
        }else{
            return response()->json([
                'status' => 500]
            );
        }
         
    }



    /***********************promotion************************ */
    public function reviewRating()
    {   
        return view('frontend.reviewRating');
    }
    public function checkoutNew()
    {   
        return view('frontend.checkoutNew');
    }
    public function promotion()
    {   
        return view('frontend.promotion');
    }

    public function bundleDeals()
    {   
        return view('frontend.bundleDeals');
    }


    public function notification()
    {   
        return view('frontend.notification');
    }

    public function helpCenter()
    {   
        return view('frontend.helpCenter');
    }

    public function contactUs()
    {   
        $states = State::select('id', 'name')->get();
        return view('frontend.contactUs',compact('states'));
    }

    public function contactUsSend(Request $request)
    {   
        $rules = [
            'name' => 'required',
            'hp' => 'required',
            'email' => 'required',
            'state' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $contactusadd = new ContactUs;
            $contactusadd->name = $request->name;
            $contactusadd->hp = $request->hp;
            $contactusadd->email = $request->email;
            $contactusadd->state = $request->state;
            $contactusadd->message = $request->message;
            $contactusadd->save();

            // \Mail::send([],[], function($message) use($request)  {
            // $message->to('ankita.desai@aipxperts.com',"Mr. Who")
            //     ->subject("Customer Connect")
            //     ->setBody('<h4>Hello,</h4><br><br><p>'.$request->name.'  is connect with '.$request->name.'</p><br><p>Thank You</p>', 'text/html');                     
            // });
            return redirect()->route('home')->with('success', 'Thank you for getting in touch! We appreciate you contacting us. One of our colleagues will get back in touch with you soon!Have a great day!');

        }
    }

    public function __invoke(Request $request,$slug)
    {
        $page = CmsPage::where('slug',$slug)->first();

        if(!$page){
            abort(404);
        }
        return view('frontend.page', compact('page'));
    }   

    public function shopDetail(Request $request,$slug)
    {
        $user = User::where('referal_code',$slug)->first();
        if(!$user){
            abort(404);
        }
        $seller = Seller::where('user_id', $user->id)->first();
        if(!$seller){
            abort(404);
        }
        $sellerId = $seller->id;
        $productCount = Product::where('seller_id', $sellerId)->count();
        $followers = SellerFollower::where('seller_id', $sellerId)->count();
        $followings = SellerFollower::where('customer_id', $sellerId)->count();
        $products = Product::where('seller_id', $sellerId)->get();
        $followings = SellerFollower::where('customer_id', $sellerId)->count();

        $shopCategories = ShopCategory::where('created_by', $sellerId)->where('display', '1')->orderBy('sequence', 'ASC')->paginate(10);

        $addReview = [];
        foreach($products as $product){
            $reviews = ReviewRating::where('product_id', $product->id)->get();
            if(count($reviews) > 0){
                foreach($reviews as $review){
                    $addReview[] = $review->rate;
                }
            }
        }
        $average = (count($addReview) > 0) ? (array_sum($addReview)/count($addReview)) : 0;
        $joined = Carbon::parse($product->seller->created_at)->diffForHumans();

        $sellerDetails = [];
        $sellerDetails['sellerId'] = $sellerId;
        $sellerDetails['user'] = $user->id;
        $sellerDetails['productCount'] = $productCount;
        $sellerDetails['followers'] = $followers;
        $sellerDetails['followings'] = $followings;
        $sellerDetails['totalRating'] = count($addReview);
        $sellerDetails['avgRating'] = $average;
        $sellerDetails['joined'] = $joined;

        $shopDecoration = ShopDecoration::with('products', 'images' , 'products.product')->where('seller_id', $sellerId)->orderBy('sequence', 'ASC')->get();
        return view('frontend.seller-shop', compact('seller', 'sellerDetails', 'shopCategories', 'shopDecoration'));
    }   

    public function sellerMall(Request $request,$seller, $id){
        $id = Helper::decrypt($id);
        $seller = Seller::with('topBanners')->with('lastBanners')->where('id', $id)->where('name', $seller)->first();
        if($seller){
            $displayCategories = DisplayCategory::with('displayCategoryBanners')
                                    ->whereHas('displayCategoryProducts.product')
                                    ->with(['displayCategoryProducts.product' => function($q) use($id) {
                                        $q->where('seller_id', $id); 
                                    }])
                                    ->where('display_on_maxshopmall', '1')
                                    ->where('status', 'active')
                                    ->orderBy('maxmall_sequence', 'asc')
                                    ->get();

            $categories = Category::with('images')
                                    ->whereHas('allproducts')
                                    ->with(['allproducts' => function ($query) {
                                        return $query->limit(8);
                                    }])
                                    ->with(['products' => function($q) use($id) {
                                        $q->where('seller_id', $id); 
                                    }])               
                                    ->with('products.images')
                                    ->where('is_deleted', '=', '0')
                                    ->where('status', 'active')
                                    ->orderBy('id', 'DESC')
                                    ->get();

            $products = Product::with('images')->whereHas('seller')  
                            ->with(['seller' => function($q) use($id) {
                                $q->where('id', $id); 
                            }])
                            ->with('reviews')->with('categories.category')->where('is_deleted', '=', '0')->where('status', "active")
                            ->limit(16)->get();
            
            return view('frontend.max-shop-mall',compact('displayCategories', 'categories', 'products', 'seller'));

        }else{
            return redirect()->route('home')->with('error', 'Seller not found!');
        }
    }
    
    public function shopCategoryProduct($id){
        $id = Helper::decrypt($id);
        $shopCategories = ShopCategory::with('products', 'products.product')->has('products')->where('id', $id)->first();
        $products = $shopCategories->products;
        $slug = $shopCategories->slug;
        $view = view('frontend.shop-category-product')->with(compact('products', 'slug'))->render();

        return response()->json([
            'status' => 200, 'view' => $view]
        );
    }
    public function viewNotification()
    {
        $getNotifications = DB::table('notifications')->where('notifiable_id', auth()->user()->id)->orderBy('created_at', 'DESC')->get();

        $notifications = [];
        foreach($getNotifications as $notification){
            $notificationData = json_decode($notification->data, true);
            if (array_key_exists('order_id', $notificationData)) {
                $orderId = $notificationData['order_id'];
                $replaceString = str_replace("\\", "/", $notification->type);
                $orderType = substr($replaceString, strrpos($replaceString, '/') + 1);
                if(isset($notifications[$orderId])){
                    $notifications[$orderId][] = [
                                                    'orderId' => $notificationData['order_id'], 
                                                    'type' => $orderType,
                                                    'created_at' => $notification->created_at
                                                ];
                }else{
                    $notifications[$orderId][] = [
                                                    'orderId' => $notificationData['order_id'], 
                                                    'type' => $orderType,
                                                    'created_at' => $notification->created_at
                                                ];
                }
            }
        }
        $notifications = $this->paginate($notifications);

        return view('profile.notification',compact('notifications'));
    }


    public function paginate($items, $perPage = 10)
    {
        $pageStart = \Request::get('page', 1);

        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;

        // Get only the items you need using array_slice
        $itemsForCurrentPage = array_slice($items, $offSet, $perPage, true);

        return new LengthAwarePaginator($itemsForCurrentPage, count($items), $perPage, Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
    }

    public function shockingsale()
    {
        $shockingsale = Shockingsale::where('status','active')->first();
        return view('frontend.shockingsaleview',compact('shockingsale'));
    }

    public function subCategory()
    {
        return view('frontend.sub-category');
    }
    
    public function viewShop()
    {
        return view('frontend.view-shop');
    }

    public function buildTree(array $elements) {
        $branch = [];
        $ids = [];
        foreach ($elements as $element) {
            $branch[] = $element['id'];
            $ids[$element['id']]= $element['id'];
            if (isset($element['subs']) && count($element['subs']) > 0) {
                $children = $this->buildTree($element['subs']);
                if ($children) {
                    $branch[] = $children;
                    $child = implode(" ",$children);
                    $childArray = explode(' ', $child);
                    foreach($childArray as $arr){
                        $ids[$arr] = (int)$arr;
                    }
                }
            }
        }

        $ids = array_keys($ids);
        return $ids;
    }
}
