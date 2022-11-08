<?php

namespace App\Http\Controllers\Api\Agent\V1;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class CategoryController extends Controller
{

    /* get all category */
    public function getCategory(Request $request)
    {
        $categories = Category::where('is_deleted', '=', '0')->where('status', 'active')->orderBy('id', 'DESC')->get();
        if ($categories && count($categories) > 0) {
            return response::json(['success' => true, "payload" => array("categories" => $categories), 'message' => 'All category', "code" => 200], 200);
        } else {
            return response::json(['success' => false, 'message' => 'No Category found!', "code" => 401], 401);
        }
    }

    /* get all products of respective category */
    public function getCategoryProducts(Request $request)
    {
        $requestData = $request->only('category_id', 'limit');

        //valid requests
        $validator = Validator::make($requestData, [
            'category_id' => 'required|integer|min:1',
            'limit' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $categoryId = $request->category_id;
        $limit = (int)$request->limit;
        $products = [];

        $category = Category::with(array('productsData'=>function($query) use($limit){
            $query->with('attributevariationprice');
            $query->with('images');
            $query->take($limit);
        }))->where('status', 'active')->where('is_deleted', '=', '0')->where('id', $categoryId)->first();

        if($category){
            if($category->productsData && count($category->productsData) > 0){
                $products = $category->productsData;
                if ($products) {
                    return response::json(['success' => true, "payload" => array("products" => $products), 'message' => 'All category', "code" => 200], 200);
                }
            }
            return response::json(['success' => false, 'message' => 'No product found!', "code" => 401], 401);
        }
        return response::json(['success' => false, 'message' => 'No Category found!', "code" => 401], 401);
    }
}
