<?php

namespace App\Http\Controllers\Seller;

use App\Attribute;
use App\AttributeVariation;
use App\AttributeVariationPrice;
use App\Product;
use App\ProductAttribute;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeVariationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if (Auth::user()->can('variations')) {
            $variations = AttributeVariation::with('product:id,name', 'attribute:id,name')->orderBy('id', 'DESC')->paginate(10);
            // return $variations;

            return view('variation.list')->with('variations', $variations);
        } else {
            \Session::flash('error', 'You are not authorized to access this feature');
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        //
        if (Auth::user()->can('variations')) {
            $products = Product::select(['id', 'name'])->where('id', $id)->first();
            $attributes = Attribute::select(['id', 'name'])->get();
            return view('variation.add')->with('products', $products)->with('attributes', $attributes);
        } else {
            \Session::flash('error', 'You are not authorized to access this feature');
            return redirect()->route('home');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $variation = array_values(array_filter($request->variation));
            $priceArray = [];
            $priceValueArray = [];
            for ($i = 0; $i < count($request->attribute); $i++) {
                for ($j = 0; $j < count($variation[$i]); $j++) {
                    $array = explode(',', $variation[$i]);

                    $productVariation = new ProductAttribute;
                    $productVariation->product_id = $request->product;
                    $productVariation->attribute_id = $request->attribute[$i];
                    // $productVariation->variation_value = $array[$k];
                    $productVariation->save();
                    // $priceArray = [];
                    for ($k = 0; $k < count($array); $k++) {
                        $attributeVariation = new AttributeVariation;
                        $attributeVariation->product_id = $request->product;
                        $attributeVariation->product_attribute_id = $productVariation->id;
                        $attributeVariation->variation_value = $array[$k];
                        $attributeVariation->save();
                        // if($request->isVariationArray[$i] == '1'){
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
                $attributeVariationPrice->product_id = $request->product;
                $attributeVariationPrice->variation_value = $cross;
                $attributeVariationPrice->variation_value_text = implode('_', $crossesValue[$key]);
                $attributeVariationPrice->cost_price = $request->customer_cost_price[$key];
                $attributeVariationPrice->customer_price = $request->customer_price[$key];
                $attributeVariationPrice->sell_price = $request->sell_price[$key];
                $attributeVariationPrice->staff_price = $request->customer_price[$key];
                $attributeVariationPrice->executive_leader_price = $request->customer_price[$key];
                $attributeVariationPrice->silver_leader_price = $request->customer_price[$key];
                $attributeVariationPrice->gold_leader_price = $request->customer_price[$key];
                $attributeVariationPrice->plat_leader_price = $request->customer_price[$key];
                $attributeVariationPrice->diamond_leader_price = $request->customer_price[$key];
                $attributeVariationPrice->qty = $request->qty[$key];
                $attributeVariationPrice->status = $request->status[$key];
                $attributeVariationPrice->save();
            }
            // return $request;
            return redirect()->route('products')->with('success', 'Product variation added successfully');

        } catch (Exception $e) {}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if (Auth::user()->can('variations')) {
            $product = Product::select('id', 'name')->with('attributes')->with('attributevariation')->with('attributevariationprice')->where('id', $id)->first();
            foreach ($product->attributes as $attr) {
                $attributeIds[] = $attr->attribute_id;
                $attributeValues[] = $attr->name;
            }
            $attributes = Attribute::select(['id', 'name'])->get();
            if ($product) {
                foreach ($product->attributevariation as $attribvar) {
                    $varValue[$attribvar['product_attribute_id']][] = $attribvar['variation_value'];
                }
                foreach ($product->attributevariation as $attribvar) {
                    $varIdValue[$attribvar['product_attribute_id']][] = $attribvar['id'];
                }
                $existance = call_user_func_array('array_merge', $varValue);
                return view('variation.edit')->with('product', $product)->with('attributes', $attributes)->with('varValue', $varValue)->with('varIdValue', $varIdValue)->with('existance', $existance)->with('attributeValues', $attributeValues)->with('attributeIds', $attributeIds);
            } else {
                return redirect()->route('products')->with('error', 'Product variation not found!');
            }
        } else {
            \Session::flash('error', 'You are not authorized to access this feature');
            return redirect()->route('home');
        }
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
        // $attributeArray = array_filter($request->attribute);
        $attributeArray = json_decode($request->attributeArray,true); 
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
                $setPrice->cost_price = $request->$combine['customer_cost_price'];
                $setPrice->customer_price = $request->$combine['customer_price'];
                $setPrice->sell_price = $request->$combine['sell_price'];
                $setPrice->staff_price = $request->$combine['customer_price'];
                $setPrice->executive_leader_price = $request->$combine['customer_price'];
                $setPrice->silver_leader_price = $request->$combine['customer_price'];
                $setPrice->gold_leader_price = $request->$combine['customer_price'];
                $setPrice->plat_leader_price = $request->$combine['customer_price'];
                $setPrice->diamond_leader_price = $request->$combine['customer_price'];
                $setPrice->qty = $request->$combine['qty'];
                $setPrice->status = $request->$combine['status'];
                $setPrice->save();
            } else {
                $setNewPrice = new AttributeVariationPrice;
                $setNewPrice->product_id = $id;
                $setNewPrice->variation_value = $idCrosses[$key];
                $setNewPrice->variation_value_text = $combine;
                $setNewPrice->cost_price = $request->$combine['customer_cost_price'];
                $setNewPrice->customer_price = $request->$combine['customer_price'];
                $setNewPrice->sell_price = $request->$combine['sell_price'];
                $setNewPrice->staff_price = $request->$combine['customer_price'];
                $setNewPrice->executive_leader_price = $request->$combine['customer_price'];
                $setNewPrice->silver_leader_price = $request->$combine['customer_price'];
                $setNewPrice->gold_leader_price = $request->$combine['customer_price'];
                $setNewPrice->plat_leader_price = $request->$combine['customer_price'];
                $setNewPrice->diamond_leader_price = $request->$combine['customer_price'];
                $setNewPrice->qty = $request->$combine['qty'];
                $setNewPrice->status = $request->$combine['status'];
                $setNewPrice->save();
            }
        }
        return redirect()->route('products')->with('success', 'Product variation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('variations')) {
            $attribute = Attribute::find($id);
            if (!$attribute) {
                \Session::flash('error', 'No recored found');
            }
            $attribute->delete();
            \Session::flash('success', 'Attribute removed successfully');
            return;
        } else {
            \Session::flash('error', 'You are not authorized to access this feature');
            return redirect()->route('home');
        }
    }

    public function isAttributeExists(Request $request)
    {
        $isValid = true;
        $message = '';

        $isExist = Attribute::where('name', '=', $request->name)->where('deleted_at', null)->first();

        if ($isExist) {
            $isValid = false;
            $message = 'Attribute already exists';
        }

        return response()->json([
            'valid' => $isValid,
            'message' => $message,
        ]);
    }

    public function pricing(Request $request)
    {
        $attributeArray = array_filter($request->attributeArray);
        $variationArray = array_filter($request->variationArray);
        $variationArray = array_combine($attributeArray, $variationArray);

        $attributes = Attribute::select(['id', 'name'])->get()->toArray();
        $attributesData = [];
        array_walk($attributes, function ($entry) use (&$attributesData) {
            $attributesData[$entry["id"]] = $entry["name"];
        });

        // $variationArrayfinal = [];
        foreach ($variationArray as $var) {
            $variationStringToArray = explode(',', $var);
            $variationArrayfinal[] = $variationStringToArray;
        }

        $totalVariation = sizeof(array_map('count', $variationArrayfinal));

        $cross = $this->array_cartesian_product(
            $variationArrayfinal
        );

        $product = Product::where('id', $request->product_id)->first();
        $view = view('seller.variation.addprice')->with(compact('attributeArray', 'cross', 'attributesData', 'product'))->render();

        return response()->json([
            'status' => 200, 'view' => $view]
        );
    }

    public function editPricing(Request $request)
    {
        $attributeArray = array_filter($request->attributeArray);
        $variationArray = array_filter($request->variationArray);
        $variationArray = array_combine($attributeArray, $variationArray);

        $attributes = Attribute::select(['id', 'name'])->get()->toArray();
        $attributesData = [];
        array_walk($attributes, function ($entry) use (&$attributesData) {
            $attributesData[$entry["id"]] = $entry["name"];
        });

        // $variationArrayfinal = [];
        foreach ($variationArray as $var) {
            $variationStringToArray = explode(',', $var);
            $variationArrayfinal[] = $variationStringToArray;
        }

        // $totalVariation = sizeof(array_map('count', $variationArrayfinal));

        $cross = $this->array_cartesian_product(
            $variationArrayfinal
        );

        foreach ($cross as $value) {
            $key = implode("_", $value);
            $newPriceCombine[$key] = $key;
        }

        $product = Product::select('id', 'name')->with('attributes')->with('attributevariation')->with('attributevariationprice')->where('id', $request->product_id)->first();

        foreach ($product->attributevariation as $attribvar) {
            $varValue[$attribvar['product_attribute_id']][] = $attribvar['variation_value'];
        }

        $priceArray = [];
        foreach ($product->attributevariation as $price) {
            $varIdValue[$price->product_attribute_id][] = $price->variation_value;
        }
        $cross = $this->array_cartesian_product(
            $varIdValue
        );
        foreach ($cross as $combine) {
            $key = implode("_", $combine);
            $existPriceCombine[$key] = $key;
        }

        $mergeNewExist = array_merge($newPriceCombine, $existPriceCombine);

        // return $product->attributevariationprice;
        $priceArrayFinal = [];
        foreach ($mergeNewExist as $setPrice) {
            $attribute_variation_prices = AttributeVariationPrice::where('variation_value_text', $setPrice)->where('product_id', $request->product_id)->first();
            if (!$attribute_variation_prices) {
                $priceArrayFinal[$setPrice] = [];
            }
            $priceArrayFinal[$setPrice] = $attribute_variation_prices;
        }
        // return $newPriceCombine['S_Pink'];
        // return $product->attributevariationprice;
        // return $priceArrayFinal;

        $product = Product::where('id', $request->product_id)->first();
        $view = view('variation.price')->with(compact('attributeArray', 'cross', 'attributesData', 'product', 'priceArrayFinal', 'newPriceCombine'))->render();

        return response()->json([
            'status' => 200, 'view' => $view]
        );
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
