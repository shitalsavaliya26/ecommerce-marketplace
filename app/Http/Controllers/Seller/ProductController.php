<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Attribute;
use App\AttributeVariation;
use App\AttributeVariationPrice;
use App\Category;
use App\Customerpricetier;
use App\Helpers\Helper;
use App\Imports\ProductsImport;
use App\Imports\ProductVarientImport;
use App\Order;
use App\Product;
use App\ProductAttribute;
use App\ProductCategory;
use App\ProductImage;
use App\Productlanguage;
use App\Seller;
use App\User;
use Auth;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;
use Response;

class ProductController extends Controller
{
    public function __construct()
    {
        ini_set('upload_max_filesize', '500M');
        ini_set('post_max_size', '500M');
        ini_set('max_execution_time', 300);
        // $user = Auth::user();
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->userseller = Seller::where('user_id',$this->user->id)->first();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $this->userseller;
        $userseller = $this->user;

        $allowed_sorts = ['name', 'created_at'];
        $searchQuery = $request->get('search');
        $data = [];
        $data['search'] = $searchQuery;
        $data['status'] = $request->get('status');

        $products = Product::with('images')->with("attributes")->with("category")->where('is_deleted', '=', '0')->orderBy('id', 'DESC');

        if (isset($searchQuery) && $searchQuery != '') {
            $products = $products->where(function ($products) use ($searchQuery) {
                $products->Where('products.name', 'like', '%' . $searchQuery . '%')
                ->orWhere('products.code', 'like', '%' . $searchQuery . '%')
                ->orWhere('products.sku', 'like', '%' . $searchQuery . '%');
            });
        }

        if ($request->has('status') && $request->status != '') {
            $products = $products->where('status', $request->status);
        }

        $products = $products->where('seller_id',$user->id)->paginate(10)->appends($request->all());
        return view('seller.product.list')->with($data)->with('products', $products)->with('user', $userseller);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->put('uploadImage', '');
        $user = $this->user;
        $userseller = $this->userseller;

        $sellers = Seller::select(['id', 'name', 'email'])->get();
        $attributes = Attribute::select(['id', 'name'])->get();
        $categories = Category::select(['id', 'name'])->where(['is_deleted' => '0', 'status' => 'active'])->get();
        return view('seller.product.add')->with('user', $user)->with('userseller', $userseller)->with('categories', $categories)->with('sellers', $sellers)->with('attributes', $attributes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->userseller;
        $userseller = $this->user;

        $data = $request->all();
        // dd($data);
        $rules = [
            'name' => 'required',
            'sku' => 'required|unique:products,sku',
            'photos_zip_file' => 'max:102400000',
        ];
        if (empty($request->is_new)) {
            $is_new = "false";
        } else {
            $is_new = $request->is_new;
        }
            // for featured and other product
        if (empty($request->is_featured)) {
            $is_featured = "0";
        } else {
            $is_featured = $request->is_featured;
        }
        if (empty($request->is_other)) {
            $is_other = "0";
        } else {
            $is_other = $request->is_other;
        }
        if (empty($request->is_variation)) {
            $is_variation = "0";
        } else {
            $is_variation = $request->is_variation;
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $image = $data['form']['file'];
            $totalImages = count($data['form']['file']);
            $validImageCount = 0;
            if ($image) {
                $validExtension = ['jpg', 'jpeg', 'png'];
                foreach ($image as $file) {
                    $image_parts = explode(";base64,", $file);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    if (key_exists(1, $image_type_aux)) {
                        if (in_array($image_type_aux[1], $validExtension)) {
                            $validImageCount++;
                        }
                    }
                }
            }
            $type = ($request->type == 'none') ? null : $request->type;
            $video = '';
            if ($totalImages == $validImageCount) {

                if ($request->has('video_url')) {
                    if ($request->type == "videolink" && (!empty($request->video_url))) {
                        $video = $request->video_url;
                        $type = $request->type;
                    }
                }

                $videothumb = '';
                $videoURL = '';
                if ($request->has('video_file')) {
                    if ($request->type == "videoupload" && (!empty($request->video_file))) {
                        $videoget = $request->file('video_file');
                        $video = time() . '.' . $videoget->getClientOriginalExtension();

                        $path = "images/productvideo/" . $video;
                        $upload_status = Storage::disk('s3')->put($path, file_get_contents($videoget), 'public');
                        $videoURL = Storage::disk('s3')->url($path);
                        $type = $request->type;
                    }
                }
                $videothumb = '';
                $zipURL = '';
                $homescreen = 0;
                $cod = 0;
                $free_shipping = '0';
                $deduct_agent_wallet = '0';
                $tag = null;
                if ($request->has('photos_zip_file') && (!empty($request->photos_zip_file))) {
                    $photo_zip = $request->file('photos_zip_file');
                    $zip = time() . '.' . $photo_zip->getClientOriginalExtension();
                    $path = "images/product_photos_zip/" . $zip;
                    $upload_status = Storage::disk('s3')->put($path, file_get_contents($photo_zip), 'public');
                    $zipURL = Storage::disk('s3')->url($path);
                }

                if ($request->has('displayhomescreen')) {
                    $homescreen = $request->displayhomescreen;
                } 

                if ($request->has('cod')) {
                    $cod = $request->cod;
                } 
                if ($request->has('free_shipping')) {
                    $free_shipping = $request->free_shipping;
                } 
                if ($request->has('deduct_agent_wallet')) {
                    $deduct_agent_wallet = $request->deduct_agent_wallet;
                } 

                if ($request->has('tag')) {
                    $tag = ($request->tag != '') ? $request->tag : null;
                } 

                $slugify = Helper::slugify($request->name);
                if (Product::where('slug', $slugify)->first()) {
                    $slugify = Helper::slugify($request->name, '-', 1);
                }

                $product = new product();
                $product->name = $data['name'];
                    // $product->category_id = $data['category'];
                $product->sku = $data['sku'];
                $product->description = $data['description'];
                $product->qty = $is_variation == '0' ? $data['qty'] : 0;
                $product->customer_price = $is_variation == '0' ? $data['customer_price'] : 0;
                $product->sell_price = $is_variation == '0' ? $data['sell_price'] : 0;
                $product->cost_price = $is_variation == '0' ? $data['customer_cost_price'] : 0;
                $product->executive_leader_price = $is_variation == '0' ? $data['customer_price'] : 0;
                $product->silver_leader_price = $is_variation == '0' ? $data['customer_price'] : 0;
                $product->gold_leader_price = $is_variation == '0' ? $data['customer_price'] : 0;
                $product->plat_leader_price = $is_variation == '0' ? $data['customer_price'] : 0;
                $product->diamond_leader_price = $is_variation == '0' ? $data['customer_price'] : 0;
                $product->staff_price = $is_variation == '0' ? $data['customer_price'] : 0;
                $product->is_deleted = "0";
                $product->seller_id = $user->id;
                $product->weight = $is_variation == '0' ? $data['weight'] : 0;
                $product->height = $is_variation == '0' ? $data['pheight'] : 0;
                $product->width = $is_variation == '0' ? $data['width'] : 0;
                $product->length = $is_variation == '0' ? $data['length'] : 0;
                // $product->is_new = $is_new;
                // $product->is_featured = $is_featured;
                // $product->is_other = $is_other;
                $product->is_variation = $is_variation;
                $product->type = $type;
                $product->video = $videoURL;
                $product->video_thumb = $videothumb;
                // $product->displayhomescreen = $homescreen;
                // $product->tag = $tag;
                $product->photos_zip_file = $zipURL;
                // $product->cod = $cod;
                // $product->free_shipping = $free_shipping;
                // $product->deduct_agent_wallet = ($free_shipping == '1') ? $deduct_agent_wallet : '0';
                // $product->sell_by_agent = (isset($data['sell_by_agent'])) ? 1 : 0;
                // $product->sell_by_staff = (isset($data['sell_by_staff'])) ? 1 : 0;
                // $product->sell_by_customer = (isset($data['sell_by_customer'])) ? 1 : 0;
                // $product->executive_pv_point = $is_variation == '0' ? $data['executive_pv_point'] : 0;
                // $product->silver_pv_point = $is_variation == '0' ? $data['silver_pv_point'] : 0;
                // $product->golden_pv_point = $is_variation == '0' ? $data['golden_pv_point'] : 0;
                // $product->platinum_pv_point = $is_variation == '0' ? $data['platinum_pv_point'] : 0;
                // $product->diamond_pv_point = $is_variation == '0' ? $data['diamond_pv_point'] : 0;
                // $product->staff_pv_point = $is_variation == '0' ? $data['staff_pv_point'] : 0;
                $product->slug = $slugify;
                $product->save();

                $image = $data['form']['file'];

                if ($image) {
                    $keys = array_keys($image);

                    for ($i = 0; $i < count($image); $i++) {
                        $file = $image[$keys[$i]];
                        $image_parts = explode(";base64,", $file);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        $image_type = $image_type_aux[1];
                        $image_base64 = base64_decode($image_parts[1]);
                        $renamed = time() . rand() . '.' . $image_type;
                        $path = "images/product/" . $renamed;
                        $upload = Storage::disk('s3')->put($path, $image_base64, 'public');
                        $fileURL = Storage::disk('s3')->url($path);
                        $productImage = new productImage();
                        $productImage->product_id = $product->id;
                        $productImage->image = $fileURL;
                        // $i++;
                        // $file = $image[$i];
                        // $image_parts = explode(";base64,", $file);
                        // $image_type_aux = explode("image/", $image_parts[0]);
                        // $image_type = $image_type_aux[1];
                        // $image_base64 = base64_decode($image_parts[1]);
                        $renamed = time() . rand() . '.' . $image_type;
                        $path = "images/product/thumb/" . $renamed;
                        $upload = Storage::disk('s3')->put($path, $image_base64, 'public');
                        $fileURL = Storage::disk('s3')->url($path);
                        $productImage->thumb = $fileURL;
                        $productImage->save();
                        $request->session()->pull('uploadImage', $image);
                    }
                }
                if (isset($data['chinese_name'])) {
                    $chinese = new Productlanguage;
                    $chinese->product_id = $product->id;
                    $chinese->language_id = '2';
                    $chinese->product_name = $data['chinese_name'];
                    $chinese->product_description = $data['description_chinese'];
                    $chinese->save();
                }
                if (isset($data['malay_name'])) {
                    $chinese = new Productlanguage;
                    $chinese->product_id = $product->id;
                    $chinese->language_id = '3';
                    $chinese->product_name = $data['malay_name'];
                    $chinese->product_description = $data['description_malay'];
                    $chinese->save();
                }
                if (isset($data['vietnamese_name'])) {
                    $chinese = new Productlanguage;
                    $chinese->product_id = $product->id;
                    $chinese->language_id = '4';
                    $chinese->product_name = $data['vietnamese_name'];
                    $chinese->product_description = $data['description_vietnamese'];
                    $chinese->save();
                }
                if (isset($data['thai_name'])) {
                    $chinese = new Productlanguage;
                    $chinese->product_id = $product->id;
                    $chinese->language_id = '5';
                    $chinese->product_name = $data['thai_name'];
                    $chinese->product_description = $data['description_thai'];
                    $chinese->save();
                }
                $customer_daynamic_product_qty = $request->customer_qty;

                if (!empty($data['category'])) {
                    foreach ($data['category'] as $category) {
                        $documentUser = new ProductCategory();
                        $documentUser->product_id = $product->id;
                        $documentUser->category_id = $category;
                        $documentUser->save();
                    }
                }

                $variation = array_values(array_filter($request->variation));
                $priceArray = [];
                $priceValueArray = [];

                if ($request->has('attribute') && !empty($request->attribute) && !empty($variation) && $is_variation == '1') {
                    for ($i = 0; $i < count($request->attribute); $i++) {
                        for ($j = 0; $j < count($variation[$i]); $j++) {
                            $array = explode(',', $variation[$i]);

                            $productVariation = new ProductAttribute;
                            $productVariation->product_id = $product->id;
                            $productVariation->attribute_id = $request->attribute[$i];
                                // $productVariation->variation_value = $array[$k];
                            $productVariation->save();
                                // $priceArray = [];
                            for ($k = 0; $k < count($array); $k++) {
                                $attributeVariation = new AttributeVariation;
                                $attributeVariation->product_id = $product->id;
                                $attributeVariation->product_attribute_id = $productVariation->id;
                                $attributeVariation->variation_value = $array[$k];
                                $attributeVariation->save();
                                $priceArray[$productVariation->id][] = $attributeVariation->id;
                                $priceValueArray[$attributeVariation->product_attribute_id][] = $attributeVariation->variation_value;
                            }
                        }
                    }

                    $crosses = $this->array_cartesian_product($priceArray);
                    $crossesValue = $this->array_cartesian_product($priceValueArray);

                    foreach ($crosses as $key => $cross) {
                        $attributeVariationPrice = new AttributeVariationPrice;
                        $attributeVariationPrice->product_id = $product->id;
                        $attributeVariationPrice->variation_value = $cross;
                        $attributeVariationPrice->variation_value_text = implode('_', $crossesValue[$key]);
                        $attributeVariationPrice->cost_price = $request->customer_cost_prices[$key];
                        $attributeVariationPrice->customer_price = $request->customer_prices[$key];
                        $attributeVariationPrice->sell_price = $request->sell_prices[$key];
                        $attributeVariationPrice->staff_price = $request->customer_prices[$key];
                        $attributeVariationPrice->executive_leader_price = $request->customer_prices[$key];
                        $attributeVariationPrice->silver_leader_price = $request->customer_prices[$key];
                        $attributeVariationPrice->gold_leader_price = $request->customer_prices[$key];
                        $attributeVariationPrice->plat_leader_price = $request->customer_prices[$key];
                        $attributeVariationPrice->diamond_leader_price = $request->customer_prices[$key];
                        $attributeVariationPrice->qty = $request->qtys[$key];
                        $attributeVariationPrice->status = $request->statuses[$key];
                        $attributeVariationPrice->length = $request->lengths[$key];
                        $attributeVariationPrice->width = $request->widths[$key];
                        $attributeVariationPrice->height = $request->heights[$key];
                        $attributeVariationPrice->weight = $request->weights[$key];
                        // $attributeVariationPrice->executive_pv_point = $request->executive_pv_points[$key];
                        // $attributeVariationPrice->silver_pv_point = $request->silver_pv_points[$key];
                        // $attributeVariationPrice->golden_pv_point = $request->golden_pv_points[$key];
                        // $attributeVariationPrice->platinum_pv_point = $request->platinum_pv_points[$key];
                        // $attributeVariationPrice->diamond_pv_point = $request->diamond_pv_points[$key];
                        // $attributeVariationPrice->staff_pv_point = $request->staff_pv_points[$key];
                        $attributeVariationPrice->save();
                    }
                }
                return redirect()->route('seller.products.index')->with('success', 'Product added successfully');
            } else {
                return redirect()->route('seller.products.index')->with('error', 'Please upload only jpg, jpeg and png files');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Helper::decrypt($id);

         $product = Product::with(['images', 'category'])->find($id);
         $product_malay = Productlanguage::where('product_id', $product->id)->where('language_id', 3)->first();
         $product_vietnamese = Productlanguage::where('product_id', $product->id)->where('language_id', 4)->first();
         $product_chinese = Productlanguage::where('product_id', $product->id)->where('language_id', 2)->first();
         $product_thai = Productlanguage::where('product_id', $product->id)->where('language_id', 5)->first();
         $daynamic_customer_price = Customerpricetier::where('product_id', $product->id)->get();
         $productPrices = AttributeVariationPrice::where('product_id', $id)->get();
         if (count($productPrices) > 0) {
            $productPrices = $productPrices;
        } else {
            $productPrices = [];
        }
            // return $productPrices;
        return view('seller.product.view')->with('product', $product)->with('product_malay', $product_malay)->with('product_vietnamese', $product_vietnamese)->with('product_thai', $product_thai)->with('product_chinese', $product_chinese)->with('daynamic_customer_price', $daynamic_customer_price)->with('productPrices', $productPrices);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $id = Helper::decrypt($id);
        $request->session()->put('uploadImage', '');
        $user = Auth::user();
        $product = Product::with(['images'])->find($id);
        $categories = Category::select(['id', 'name'])->where(['is_deleted' => '0', 'status' => 'active'])->get();
        $product_chinese = Productlanguage::where('product_id', $product->id)->where('language_id', 2)->first();
        $product_malay = Productlanguage::where('product_id', $product->id)->where('language_id', 3)->first();
        $product_vietnamese = Productlanguage::where('product_id', $product->id)->where('language_id', 4)->first();
        $product_thai = Productlanguage::where('product_id', $product->id)->where('language_id', 5)->first();
        $daynamic_customer_price = Customerpricetier::where('product_id', $product->id)->get();
        $sellers = Seller::select(['id', 'name', 'email'])->get();
        $selectedcategories = ($product->categories()->pluck('category_id')) ? $product->categories()->pluck('category_id')->toArray() : [];
            // print_r($selectedcategories);die();

        $productData = Product::select('id', 'name')->with('attributes')->with('attributevariation')->with('attributevariationprice')->where('id', $id)->first();
        $attributeIds = [];
        $attributeValues = [];

        if (!empty((array) $productData->attributes)) {
            foreach ($productData->attributes as $attr) {
                $attributeIds[] = $attr->attribute_id;
                $attributeValues[] = $attr->name;
            }
        }
        $attributes = Attribute::select(['id', 'name'])->get();
        $varValue = [];
        $varIdValue = [];
        foreach ($productData->attributevariation as $attribvar) {
            $varValue[$attribvar['product_attribute_id']][] = $attribvar['variation_value'];
        }
        foreach ($productData->attributevariation as $attribvar) {
            $varIdValue[$attribvar['product_attribute_id']][] = $attribvar['id'];
        }

        $existance = [];
        if (!empty($varValue)) {
            $existance = call_user_func_array('array_merge', $varValue);
        }
        return view('seller.product.edit')->with('product', $product)->with('categories', $categories)->with('user', $user)->with('product_chinese', $product_chinese)->with('product_malay', $product_malay)->with('product_vietnamese', $product_vietnamese)->with('product_thai', $product_thai)->with('daynamic_customer_price', $daynamic_customer_price)->with('selectedcategories', $selectedcategories)->with('sellers', $sellers)->with('attributes', $attributes)->with('varValue', $varValue)->with('varIdValue', $varIdValue)->with('existance', $existance)->with('attributeValues', $attributeValues)->with('attributeIds', $attributeIds)->with('productData', $productData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = Helper::decrypt($id);

        $type = null;
        $videothumb = '';
        $video = '';
        $data = $request->all();
            // print_r($data);die();
        $user = Auth::user();
        $product = Product::with(['images'])->find($id);
        $validator = Validator::make(
            $request->all(),
            array(
                'name' => 'required',
                'sku' => 'required|unique:products,sku,' . $id,
                'customer_qty_edit.*' => 'min:1',
                'photos_zip_file' => 'max:102400000',

            ),
            [
                'name.required' => "Name is required",
                'customer_qty_edit.*.min' => "please enter Customer price tire quantity",
            ]
        );
        if (empty($request->is_new)) {
            $is_new = "false";
        } else {
            $is_new = $request->is_new;
        }
            // for featured and other product
        if (empty($request->is_featured)) {
            $is_featured = "0";
        } else {
            $is_featured = $request->is_featured;
        }
        if (empty($request->is_other)) {
            $is_other = "0";
        } else {
            $is_other = $request->is_other;
        }

        if ($validator->fails()) {
            $user = Auth::user();
            $product = Product::with(['images'])->find($id);
            $categories = Category::select(['id', 'name'])->where(['is_deleted' => '0', 'status' => 'active'])->get();
            $product_chinese = Productlanguage::where('product_id', $product->id)->where('language_id', 2)->first();
            $product_malay = Productlanguage::where('product_id', $product->id)->where('language_id', 3)->first();
            $product_vietnamese = Productlanguage::where('product_id', $product->id)->where('language_id', 4)->first();
            $product_thai = Productlanguage::where('product_id', $product->id)->where('language_id', 5)->first();
            $daynamic_customer_price = Customerpricetier::where('product_id', $product->id)->get();
            $selectedcategories = ($product->categories()->pluck('category_id')) ? $product->categories()->pluck('category_id')->toArray() : [];
            $sellers = Seller::select(['id', 'name'])->get();
                // print_r($selectedcategories);die();
            return view('product.edit')->with('product', $product)->with('categories', $categories)->with('user', $user)->with('product_chinese', $product_chinese)->with('product_malay', $product_malay)->with('product_vietnamese', $product_vietnamese)->with('product_thai', $product_thai)->with('daynamic_customer_price', $daynamic_customer_price)->with('selectedcategories', $selectedcategories)->with('sellers', $sellers)->withErrors($validator);
        } else {
            if ($request->has('tag')) {
                $tag = ($request->tag != '') ? $request->tag : null;
            } else {
                $tag = null;
            }

            if ($request->has('video_url')) {
                if ($request->type == "videolink" && (!empty($request->video_url))) {
                    $video = $request->video_url;
                    $type = $request->type;
                }
            } else {
                if ($request->type == "none") {
                    $video = null;
                    $type = null;
                }

            }

            if ($request->type == "none") {
                $video = null;
                $type = null;
                $videothumb = null;
            } else {
                if ($request->type == "videoupload" && (!empty($request->old_video))) {
                    $video = $request->old_video;
                    $type = $request->type;
                    $videothumb = basename($product->video_thumb);
                }
            }

            $videoURL = $product->video;
            if ($request->has('video_file')) {
                if ($request->type == "videoupload" && (!empty($request->video_file))) {
                    $originalmage = $product->video;
                    $s3path = parse_url($originalmage);
                    if (Storage::disk('s3')->exists($s3path['path'])) {
                        Storage::disk('s3')->delete($s3path['path']);
                    }
                    $videoget = $request->file('video_file');
                    $video = time() . '.' . $videoget->getClientOriginalExtension();
                    $path = "images/productvideo/" . $video;
                    $upload_status = Storage::disk('s3')->put($path, file_get_contents($videoget), 'public');
                    $videoURL = Storage::disk('s3')->url($path);

                    $type = $request->type;
                }
            }

            $homescreen = 0;
            $cod = 0;
            $free_shipping = '0';
            $deduct_agent_wallet = '0';
            if ($request->has('displayhomescreen')) {
                $homescreen = $request->displayhomescreen;
            } 
            if ($request->has('cod')) {
                $cod = $request->cod;
            } 

            if ($request->has('free_shipping')) {
                $free_shipping = $request->free_shipping;
            } 

            if ($request->has('deduct_agent_wallet')) {
                $deduct_agent_wallet = $request->deduct_agent_wallet;
            } 
            if ($product->is_variation == 0) {
                $variation = array_values(array_filter($request->variation));
                $priceArray = [];
                $priceValueArray = [];
                if ($request->has('attribute') && !empty($request->attribute) && !empty($variation)) {
                    for ($i = 0; $i < count($request->attribute); $i++) {
                        for ($j = 0; $j < count($variation[$i]); $j++) {
                            $array = explode(',', $variation[$i]);

                            $productVariation = new ProductAttribute;
                            $productVariation->product_id = $product->id;
                            $productVariation->attribute_id = $request->attribute[$i];
                                // $productVariation->variation_value = $array[$k];
                            $productVariation->save();
                                // $priceArray = [];
                            for ($k = 0; $k < count($array); $k++) {
                                $attributeVariation = new AttributeVariation;
                                $attributeVariation->product_id = $product->id;
                                $attributeVariation->product_attribute_id = $productVariation->id;
                                $attributeVariation->variation_value = $array[$k];
                                $attributeVariation->save();
                                $priceArray[$productVariation->id][] = $attributeVariation->id;
                                $priceValueArray[$attributeVariation->product_attribute_id][] = $attributeVariation->variation_value;
                                    // }
                            }
                        }
                    }

                    $crosses = $this->array_cartesian_product($priceArray);
                    $crossesValue = $this->array_cartesian_product($priceValueArray);

                    foreach ($crosses as $key => $cross) {
                        $attributeVariationPrice = new AttributeVariationPrice;
                        $attributeVariationPrice->product_id = $product->id;
                        $attributeVariationPrice->variation_value = $cross;
                        $attributeVariationPrice->variation_value_text = implode('_', $crossesValue[$key]);
                        $attributeVariationPrice->cost_price = $request->customer_cost_prices[$key];
                        $attributeVariationPrice->customer_price = $request->customer_prices[$key];
                        $attributeVariationPrice->sell_price = $request->sell_prices[$key];
                        $attributeVariationPrice->staff_price = $request->customer_prices[$key];
                        $attributeVariationPrice->executive_leader_price = $request->customer_prices[$key];
                        $attributeVariationPrice->silver_leader_price = $request->customer_prices[$key];
                        $attributeVariationPrice->gold_leader_price = $request->customer_prices[$key];
                        $attributeVariationPrice->plat_leader_price = $request->customer_prices[$key];
                        $attributeVariationPrice->diamond_leader_price = $request->customer_prices[$key];
                        $attributeVariationPrice->qty = $request->qtys[$key];
                        $attributeVariationPrice->status = $request->statuses[$key];
                        $attributeVariationPrice->length = $request->lengths[$key];
                        $attributeVariationPrice->width = $request->widths[$key];
                        $attributeVariationPrice->height = $request->heights[$key];
                        $attributeVariationPrice->weight = $request->weights[$key];
                        // $attributeVariationPrice->executive_pv_point = $request->executive_pv_points[$key];
                        // $attributeVariationPrice->silver_pv_point = $request->silver_pv_points[$key];
                        // $attributeVariationPrice->golden_pv_point = $request->golden_pv_points[$key];
                        // $attributeVariationPrice->platinum_pv_point = $request->platinum_pv_points[$key];
                        // $attributeVariationPrice->diamond_pv_point = $request->diamond_pv_points[$key];
                        // $attributeVariationPrice->staff_pv_point = $request->staff_pv_points[$key];
                        $attributeVariationPrice->save();
                    }
                }
            } else {
                $attributeArray = json_decode($request->attributeArray, true);
                $variationArray = array_filter($request->variation);
                foreach ($variationArray as $variation) {
                    $variationArrayfinal[] = explode(',', $variation);
                }
                $variationArray = array_combine($attributeArray, $variationArrayfinal);

                foreach ($variationArray as $key => $var) {
                    foreach ($var as $storeVar) {
                        $productAttributeData = ProductAttribute::where('attribute_id', $key)->where('product_id', $id)->first();
                        $setVar = AttributeVariation::where('product_id', $id)->where('variation_value', $storeVar)->first();
                        if (count($setVar) <= 0) {
                            $attributeVariation = new AttributeVariation;
                            $attributeVariation->product_id = $id;
                            $attributeVariation->product_attribute_id = $productAttributeData->id;
                            $attributeVariation->variation_value = $storeVar;
                            $attributeVariation->save();
                        }
                    }
                }

                $crosses = $this->array_cartesian_product(
                    $variationArrayfinal
                );

                $combineArray = [];
                foreach ($crosses as $cross) {
                    $variationArrayToString = implode('_', $cross);
                    $combineArray[] = $variationArrayToString;
                }

                $allAttributeVariation = AttributeVariation::where('product_id', $id)->get();
                $idArray = [];

                foreach ($allAttributeVariation as $key => $var) {
                    $idArray[$var->product_attribute_id][] = $var->id;
                }

                $idCrosses = $this->array_cartesian_product(
                    $idArray
                );

                foreach ($combineArray as $key => $combine) {
                    $setPrice = AttributeVariationPrice::where('product_id', $id)->where('variation_value_text', $combine)->first();
                    if (count($setPrice) == 1) {
                        $setPrice->cost_price = $request->$combine['customer_cost_prices'];
                        $setPrice->customer_price = $request->$combine['customer_prices'];
                        $setPrice->sell_price = $request->$combine['sell_prices'];
                        $setPrice->staff_price = $request->$combine['customer_prices'];
                        $setPrice->executive_leader_price = $request->$combine['customer_prices'];
                        $setPrice->silver_leader_price = $request->$combine['customer_prices'];
                        $setPrice->gold_leader_price = $request->$combine['customer_prices'];
                        $setPrice->plat_leader_price = $request->$combine['customer_prices'];
                        $setPrice->diamond_leader_price = $request->$combine['customer_prices'];
                        $setPrice->qty = $request->$combine['qtys'];
                        $setPrice->status = $request->$combine['statuses'];
                        $setPrice->length = $request->$combine['lengths'];
                        $setPrice->width = $request->$combine['widths'];
                        $setPrice->height = $request->$combine['heights'];
                        $setPrice->weight = $request->$combine['weights'];
                        // $setPrice->executive_pv_point = $request->$combine['executive_pv_points'];
                        // $setPrice->silver_pv_point = $request->$combine['silver_pv_points'];
                        // $setPrice->golden_pv_point = $request->$combine['golden_pv_points'];
                        // $setPrice->platinum_pv_point = $request->$combine['platinum_pv_points'];
                        // $setPrice->diamond_pv_point = $request->$combine['diamond_pv_points'];
                        // $setPrice->staff_pv_point = $request->$combine['staff_pv_points'];
                        $setPrice->update();
                    } else {
                        $setNewPrice = new AttributeVariationPrice;
                        $setNewPrice->product_id = $id;
                        $setNewPrice->variation_value = $idCrosses[$key];
                        $setNewPrice->variation_value_text = $combine;
                        $setNewPrice->cost_price = $request->$combine['customer_cost_prices'];
                        $setNewPrice->customer_price = $request->$combine['customer_prices'];
                        $setNewPrice->sell_price = $request->$combine['sell_prices'];
                        $setNewPrice->staff_price = $request->$combine['customer_prices'];
                        $setNewPrice->executive_leader_price = $request->$combine['customer_prices'];
                        $setNewPrice->silver_leader_price = $request->$combine['customer_prices'];
                        $setNewPrice->gold_leader_price = $request->$combine['customer_prices'];
                        $setNewPrice->plat_leader_price = $request->$combine['customer_prices'];
                        $setNewPrice->diamond_leader_price = $request->$combine['customer_prices'];
                        $setNewPrice->qty = $request->$combine['qtys'];
                        $setNewPrice->status = $request->$combine['statuses'];
                        // $setNewPrice->executive_pv_point = $request->$combine['executive_pv_points'];
                        // $setNewPrice->silver_pv_point = $request->$combine['silver_pv_points'];
                        // $setNewPrice->golden_pv_point = $request->$combine['golden_pv_points'];
                        // $setNewPrice->platinum_pv_point = $request->$combine['platinum_pv_points'];
                        // $setNewPrice->diamond_pv_point = $request->$combine['diamond_pv_points'];
                        // $setNewPrice->staff_pv_point = $request->$combine['staff_pv_points'];
                        $setNewPrice->save();
                    }
                }
            }

            $product = Product::find($id);
            if (!$request->has('is_variation')) {
                $is_variation = '1';
            } else {
                $is_variation = $request->is_variation;
            }
            $product->name = $data['name'];
                // $product->category_id = $data['category'];
            $product->sku = $data['sku'];
            $product->description = $data['description'];
            $product->qty = $is_variation == '0' ? $data['qty'] : 0;
            $product->customer_price = $data['customer_price'];
            $product->cost_price = (isset($data['customer_cost_price'])) ? $data['customer_cost_price'] : 0;
            $product->sell_price = $data['sell_price'];
            $product->staff_price = $data['customer_price'];
            $product->executive_leader_price = $data['customer_price'];
            $product->silver_leader_price = $data['customer_price'];
            $product->gold_leader_price = $data['customer_price'];
            $product->plat_leader_price = $data['customer_price'];
            $product->diamond_leader_price = $data['customer_price'];
            $product->is_deleted = "0";
            $product->weight = $data['weight'];
            $product->height = $data['pheight'];
            $product->width = $data['width'];
            $product->length = $data['length'];
            $product->is_new = $is_new;
            // $product->is_featured = $is_featured;
            // $product->is_other = $is_other;
            $product->is_variation = $is_variation;
            // $product->seller_id = $data['seller_id'];
            $product->status = $data['status'];
            $product->type = $type;
            $product->video = $videoURL;
            $product->video_thumb = $videothumb;
            // $product->displayhomescreen = $homescreen;
            // $product->tag = $tag;
            // $product->cod = $cod;
            // $product->free_shipping = $free_shipping;
            // $product->deduct_agent_wallet = ($free_shipping == '1') ? $deduct_agent_wallet : '0';
            // $product->sell_by_agent = 0;
            // $product->sell_by_staff = 0;
            // $product->sell_by_customer = 0;
            // $product->executive_pv_point = $is_variation == '0' ? $data['executive_pv_point'] : 0;
            // $product->silver_pv_point = $is_variation == '0' ? $data['silver_pv_point'] : 0;
            // $product->golden_pv_point = $is_variation == '0' ? $data['golden_pv_point'] : 0;
            // $product->platinum_pv_point = $is_variation == '0' ? $data['platinum_pv_point'] : 0;
            // $product->diamond_pv_point = $is_variation == '0' ? $data['diamond_pv_point'] : 0;
            // $product->staff_pv_point = $is_variation == '0' ? $data['staff_pv_point'] : 0;
            if ($request->has('photos_zip_file') && (!empty($request->photos_zip_file))) {

                $originalmage = $product->photos_zip_file;
                $s3path = parse_url($originalmage);
                if (Storage::disk('s3')->exists($s3path['path'])) {
                    Storage::disk('s3')->delete($s3path['path']);
                }
                $photo_zip = $request->file('photos_zip_file');
                $zip = time() . '.' . $photo_zip->getClientOriginalExtension();
                $path = "images/product_photos_zip/" . $zip;
                $upload = Storage::disk('s3')->put($path, file_get_contents($photo_zip), 'public');
                $zipURL = Storage::disk('s3')->url($path);
                $product->photos_zip_file = $zipURL;
            }
            $product->save();

            if (isset($data['remove_img']) && $data['remove_img'] != '') {
                $removeImage = explode(",", $data['remove_img']);
                foreach ($removeImage as $image) {
                    $existingImage = ProductImage::find($image);
                    $originalmage = $existingImage->image;
                    $s3path = parse_url($originalmage);
                    if (Storage::disk('s3')->exists($s3path['path'])) {
                        Storage::disk('s3')->delete($s3path['path']);
                    }
                    $thumbmage = $existingImage->thumb;
                    $s3path = parse_url($thumbmage);
                    if (Storage::disk('s3')->exists($s3path['path'])) {
                        Storage::disk('s3')->delete($s3path['path']);
                    }
                    $existingImage->delete();
                }
            }
            if (isset($data['form'])) {

                $image = $data['form']['file'];
                $totalImages = count($data['form']['file']);
                $validImageCount = 0;
                if ($image) {
                    $validExtension = ['jpg', 'jpeg', 'png'];
                    foreach ($image as $file) {
                        $image_parts = explode(";base64,", $file);
                        $image_type_aux = explode("image/", $image_parts[0]);
                        if (key_exists(1, $image_type_aux)) {
                            if (in_array($image_type_aux[1], $validExtension)) {
                                $validImageCount++;
                            }
                        }
                    }
                }
                if ($totalImages == $validImageCount) {
                    $images = $request->session()->get('uploadImage');
                    if ($request->session()->get('uploadImage') != '') {
                        foreach ($images as $image) {
                            $productImage = new productImage();
                            $productImage->product_id = $product->id;
                            $productImage->image = $image;
                            $productImage->save();
                            $request->session()->pull('uploadImage', $image);
                        }
                    }

                    if (isset($data['form'])) {

                        $image = $data['form']['file'];

                        if ($image) {
                            $keys = array_keys($image);
                            for ($i = 0; $i < count($image); $i++) {
                                $file = $image[$keys[$i]];
                                $image_parts = explode(";base64,", $file);
                                $image_type_aux = explode("image/", $image_parts[0]);
                                $image_type = $image_type_aux[1];
                                $image_base64 = base64_decode($image_parts[1]);
                                $renamed = time() . rand() . '.' . $image_type;
                                $path = "images/product/" . $renamed;
                                $upload = Storage::disk('s3')->put($path, $image_base64, 'public');
                                $fileURL = Storage::disk('s3')->url($path);
                                $productImage = new productImage();
                                $productImage->product_id = $product->id;
                                $productImage->image = $fileURL;
                                // $i++;
                                // $file = $image[$i];
                                // $image_parts = explode(";base64,", $file);
                                // $image_type_aux = explode("image/", $image_parts[0]);
                                // $image_type = $image_type_aux[1];
                                // $image_base64 = base64_decode($image_parts[1]);
                                $renamed = time() . rand() . '.' . $image_type;
                                $path = "images/product/thumb/" . $renamed;
                                $upload = Storage::disk('s3')->put($path, $image_base64, 'public');
                                $fileURL = Storage::disk('s3')->url($path);
                                $productImage->thumb = $fileURL;
                                $productImage->save();
                                $request->session()->pull('uploadImage', $image);
                            }

                        }
                    }
                } else {
                    return redirect()->route('seller.products.index')->with('error', 'Please upload only jpg, jpeg and png files');
                }
            }
            if (isset($data['chinese_name'])) {
                $chinese = Productlanguage::where('product_id', $product->id)->where('language_id', 2)->first();
                if (count($chinese) == 0) {
                    $chinese = new Productlanguage;
                }
                $chinese->product_id = $product->id;
                $chinese->language_id = '2';
                $chinese->product_name = $data['chinese_name'];
                $chinese->product_description = $data['description_chinese'];
                $chinese->save();
            }
            if (isset($data['malay_name'])) {
                $malay = Productlanguage::where('product_id', $product->id)->where('language_id', 3)->first();
                if (count($malay) == 0) {
                    $malay = new Productlanguage;
                }
                $malay->product_id = $product->id;
                $malay->language_id = '3';
                $malay->product_name = $data['malay_name'];
                $malay->product_description = $data['description_malay'];
                $malay->save();
            }
            if (isset($data['vietnamese_name'])) {
                $malay = Productlanguage::where('product_id', $product->id)->where('language_id', 4)->first();
                if (count($malay) == 0) {
                    $malay = new Productlanguage;
                }

                $malay->product_id = $product->id;
                $malay->language_id = '4';
                $malay->product_name = $data['vietnamese_name'];
                $malay->product_description = $data['description_vietnamese'];
                $malay->save();
            }
            if (isset($data['thai_name'])) {
                $malay = Productlanguage::where('product_id', $product->id)->where('language_id', 5)->first();
                if (count($malay) == 0) {
                    $malay = new Productlanguage;
                }

                $malay->product_id = $product->id;
                $malay->language_id = '5';
                $malay->product_name = $data['thai_name'];
                $malay->product_description = $data['description_thai'];
                $malay->save();
            }

            ProductCategory::where('product_id', $product->id)->delete();

            if (!empty($data['category'])) {
                foreach ($data['category'] as $category) {
                    $documentUser = new ProductCategory();
                    $documentUser->product_id = $product->id;
                    $documentUser->category_id = $category;
                    $documentUser->save();
                }
            }

                // $delete_customer_price = $request->delete_daynamic_price;
                // for ($i = 0; $i < count($delete_customer_price); $i++) {
                //     $customerPrice = Customerpricetier::where('id', $delete_customer_price[$i])->delete();
                // }
            return redirect()->route('seller.products.index')->with('success', 'Product updated successfully');

        }
        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $id = Helper::decrypt($id);

        $request->session()->put('uploadImage', '');

        $orders = Order::with('orderProduct')
        ->whereHas('orderProduct', function ($query) use ($id) {
            $query->where('order_products.product_id', '=', $id);
        })->where('status', '=', 'pending')->get();

        if ($orders->count() != 0) {
            \Session::flash('error', 'After complete all order. try to delete the product');
            return redirect()->route('products')->with('success', 'Product deleted successfully');
        } else {
            $product = Product::find($id);

            $productImage = ProductImage::where('product_id', $product->id)->get();
            foreach ($productImage as $picture) {
                $originalmage = $picture->image;
                $s3path = parse_url($originalmage);
                if (Storage::disk('s3')->exists($s3path['path'])) {
                    Storage::disk('s3')->delete($s3path['path']);
                }
                ProductImage::where('id', $picture->id)->delete();
            }

            $product->is_deleted = '1';
            $product->save();
            \Session::flash('success', 'Product removed successfully');
            return response::json(['success' => false, 'message' => 'Product deleted successfully', "code" => 200], 200);
        }
    }

    public function array_cartesian_product($arrays)
    {
        $result = array();
        $arrays = array_values($arrays);
        $sizeIn = sizeof($arrays);
        $size = $sizeIn > 0 ? 1 : 0;
        foreach ($arrays as $array) {
            $size = $size * sizeof($array);
        }

        for ($i = 0; $i < $size; $i++) {
            $result[$i] = array();
            for ($j = 0; $j < $sizeIn; $j++) {
                array_push($result[$i], current($arrays[$j]));
            }
            for ($j = ($sizeIn - 1); $j >= 0; $j--) {
                if (next($arrays[$j])) {
                    break;
                } elseif (isset($arrays[$j])) {
                    reset($arrays[$j]);
                }

            }
        }
        return $result;
    }
}
