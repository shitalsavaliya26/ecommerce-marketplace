<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\ShopCategory;
use App\ShopCategoryProduct;
use App\Product;
use Illuminate\Http\Request;
use Auth;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;

class ShopCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellerId = Auth::user()->seller->id;
        $shopCategories = ShopCategory::with('products')->where('created_by', $sellerId)->orderBy('sequence', 'ASC')->paginate(10);
        return view('seller.shopcategory.list')->with('shopCategories', $shopCategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                "name" => "required",
            )
        );
        $maxSequence = ShopCategory::max('sequence');
        $sequence = ($maxSequence > 0 && $maxSequence != '' && $maxSequence != null) ? ($maxSequence + 1) : 1;

        if ($validator->fails()) {
            dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $slugify = Helper::slugify($request->name);

            $shopCategory = new ShopCategory();
            $shopCategory->display_name = $request->name;
            $shopCategory->slug = $slugify;
            $shopCategory->created_by = Auth::user()->seller->id;
            $shopCategory->display = '0';
            $shopCategory->sequence = $sequence;
            $shopCategory->save();

            return redirect()->route('seller.shop_categories.index')->with('success', 'Shop Category added successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ShopCategory $shopCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopCategory $shopCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShopCategory $shopCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Helper::decrypt($id);
        $category = ShopCategory::find($id);
        if (!$category) {
            \Session::flash('error', 'No recored found');
            return response()->json(['success' => false, 'message' => 'Product deleted successfully', "code" => 200], 200);
        }
        $category->delete();
        \Session::flash('success', 'Shop category removed successfully');
        return response()->json(['success' => true, 'message' => 'Product deleted successfully', "code" => 200], 200);
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function updateDisplay(Request $request)
    {
        $category = ShopCategory::find($request->category_id); 
        $category->display = $request->display; 
        $category->save(); 
        return response()->json(['success'=>'Display change successfully.']);
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function updateDisplayName(Request $request)
    {
        $category = ShopCategory::find($request->id); 
        $category->display_name = $request->displayName; 
        $category->save(); 
        return response()->json(['success'=>'Display change successfully.']);
    }

    public function updateSequenceOfShopCategory(Request $request)
    {
        if ($request->has('category_ids')) {
            $sequence = 1;
            foreach ($request->category_ids as $id) {
                $displayCategory = ShopCategory::find($id);
                $displayCategory->sequence = $sequence;
                $displayCategory->save();
                $sequence++;
            }
            return response()->json([
                'status' => 'done']
            );
        }else{
            return response()->json([
                'error' => 'Something went wrong!']
            );
        }
    }

    public function addProduct(Request $request, $id)
    {
        $categoryId = Helper::decrypt($id);
        $sellerId = Auth::user()->seller->id;
        $productIdsOfCategory = ShopCategoryProduct::where('shop_category_id', $categoryId)->pluck('product_id')->toArray();
        $products = Product::where('seller_id',$sellerId)->where('is_deleted','0')->where('status','active')->get();
        $productsOfCategory = ShopCategoryProduct::with('product')->where('shop_category_id', $categoryId)->get();
        return view('seller.shopcategory.addproduct')->with('categoryId', $categoryId)->with('products', $products)->with('productsOfCategory', $productsOfCategory)->with('productIdsOfCategory', $productIdsOfCategory);
    }

    public function storeProduct(Request $request)
    {
        $categoryId = $request->categoryId;
        $sellerId = Auth::user()->seller->id;
        $products = ($request->has('product') && count($request->product) > 0) ? $request->product : [];

        if($request->has('product') && count($request->product) > 0){
            ShopCategoryProduct::where('shop_category_id', $categoryId)->delete();

            foreach($products as $product){
                $shopCategoryProduct = new ShopCategoryProduct();
                $shopCategoryProduct->seller_id = $sellerId;
                $shopCategoryProduct->shop_category_id = $categoryId;
                $shopCategoryProduct->product_id = $product;
                $shopCategoryProduct->save();
            }
        }
        return redirect()->route('seller.shop-categories.add-product', [Helper::encrypt($categoryId)])->with('success', 'Shop category product added successfully');
    }

    public function deleteProduct(Request $request)
    {
        if($request->has('type') && $request->type == 'multi'){
            ShopCategoryProduct::where('shop_category_id', $request->categoryId)->whereIn('id', $request->product_ids)->delete();
        }else{
            $shopCategoryProductId = Helper::decrypt($request->id);
            $shopCategoryProduct = ShopCategoryProduct::find($shopCategoryProductId); 
            if (!$shopCategoryProduct) {
                \Session::flash('error', 'No record found');
                return response()->json(['success' => false, 'message' => 'No record found', "code" => 200], 200);
            }
            $shopCategoryProduct->delete();
        }
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
