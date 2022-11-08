<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Product;
use App\Seller;
use App\Voucher;
use App\VoucherProduct;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Response;

class VoucherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vouchers = Voucher::where('created_by', Auth::user()->id)->orderBy('id', 'DESC')->paginate(10);
        return view('seller.voucher.list')->with('vouchers', $vouchers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $products = Product::select(['id', 'name'])->where('is_deleted', '=', '0')
            ->orderBy('id', 'DESC')->get();
        $seller = Seller::select(['id', 'user_id', 'name'])->where('user_id', Auth::user()->id)->first();
        return view('seller.voucher.add')->with('products', $products)->with('seller', $seller);
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
                "type" => "required",
                "name" => "required",
                "code" => "required",
                "fromDate" => "required",
                "toDate" => "required",
                "target_buyer" => 'required_if:type,==,"seller"|nullable',
                "discount_price" => "required",
                "max_discount_price" => 'required_if:max_discount_price_type,==,"limit"|nullable',
                "min_basket_price" => "required",
                "usage_qty" => "required",
                'seller' => 'required_if:type,==,"seller"',
                "products" => 'required_if:type,==,"product"|nullable',
            )
        );

        if ($validator->fails()) {
            dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $display_voucher_early = '0';
            if ($request->has('display_voucher_early')) {
                $display_voucher_early = '1';
            }

            $purchased_time = null;
            $past_days = null;
            if ($request->target_buyer == 'repeat_purchase_buyer') {
                $purchased_time = $request->purchased_time;
                $past_days = $request->past_days;
            }

            $targetBuyer = null;
            if ($request->has('target_buyer') && $request->type == 'seller') {
                $targetBuyer = $request->target_buyer;
            }

            $voucher = new Voucher();
            $voucher->type = $request->type;
            $voucher->name = $request->name;
            $voucher->code = $request->code;
            $voucher->from_date = $request->fromDate;
            $voucher->to_date = $request->toDate;
            $voucher->display_voucher_early = $display_voucher_early;
            $voucher->target_buyer = $targetBuyer;
            $voucher->purchased_time = $purchased_time;
            $voucher->past_days = $past_days;
            $voucher->reward_type = $request->reward_type;
            $voucher->discount_type = $request->discount_type;
            $voucher->discount_price = $request->discount_price;
            $voucher->max_discount_price_type = $request->max_discount_price_type;
            $voucher->max_discount_price = ($request->max_discount_price_type == 'limit') ? $request->max_discount_price : null;
            $voucher->min_basket_price = $request->min_basket_price;
            $voucher->usage_qty = $request->usage_qty;
            $voucher->voucher_display = $request->voucher_display;
            $voucher->seller_id = ($request->type == 'seller') ? $request->seller : null;
            $voucher->created_by = Auth::user()->id;
            $voucher->save();

            if ($request->type == 'product') {
                if (!empty($request->products)) {
                    foreach ($request->products as $product) {
                        $voucherProduct = new VoucherProduct();
                        $voucherProduct->voucher_id = $voucher->id;
                        $voucherProduct->product_id = $product;
                        $voucherProduct->save();
                    }
                }
            }
            return redirect()->route('seller.vouchers.index')->with('success', 'Voucher added successfully');
        }
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
        $voucher = Voucher::with('products')->find($id);
        if ($voucher) {
            $products = Product::select(['id', 'name'])->where('is_deleted', '=', '0')
                ->orderBy('id', 'DESC')->get();

            $seller = Seller::select(['id', 'user_id', 'name'])->where('user_id', Auth::user()->id)->first();
            $selectedproducts = ($voucher->products()->pluck('product_id')) ? $voucher->products()->pluck('product_id')->toArray() : [];

            return view('seller.voucher.edit')->with('voucher', $voucher)->with('products', $products)->with('seller', $seller)->with('selectedproducts', $selectedproducts);
        } else {
            return redirect()->route('seller.vouchers.index')->with('error', 'Voucher not found!');
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
        $voucher = Voucher::find($id);

        $validator = Validator::make(
            $request->all(),
            array(
                "name" => "required",
                "code" => "required",
                "fromDate" => "required",
                "toDate" => "required",
                "target_buyer" => 'required_if:type,==,"seller"|nullable',
                "discount_price" => "required",
                "max_discount_price" => 'required_if:max_discount_price_type,==,"limit"|nullable',
                "min_basket_price" => "required",
                "usage_qty" => "required",
                'seller' => 'required_if:type,==,"seller"',
                "products" => 'required_if:type,==,"product"',
            )
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $display_voucher_early = $voucher->display_voucher_early;
            if ($request->has('display_voucher_early')) {
                $display_voucher_early = '1';
            }

            $purchased_time = $voucher->purchased_time;
            $past_days = $voucher->past_days;

            if ($request->target_buyer == 'repeat_purchase_buyer') {
                $purchased_time = $request->purchased_time;
                $past_days = $request->past_days;
            }

            $voucher->name = $request->name;
            $voucher->code = $request->code;
            $voucher->from_date = $request->fromDate;
            $voucher->to_date = $request->toDate;
            $voucher->display_voucher_early = $display_voucher_early;
            $voucher->target_buyer = $request->has('target_buyer') ? $request->target_buyer : null;
            $voucher->purchased_time = $purchased_time;
            $voucher->past_days = $past_days;
            $voucher->reward_type = $request->reward_type;
            $voucher->discount_type = $request->discount_type;
            $voucher->discount_price = $request->discount_price;
            $voucher->max_discount_price_type = $request->max_discount_price_type;
            $voucher->max_discount_price = ($request->max_discount_price_type == 'limit') ? $request->max_discount_price : null;
            $voucher->min_basket_price = $request->min_basket_price;
            $voucher->usage_qty = $request->usage_qty;
            $voucher->voucher_display = $request->voucher_display;
            $voucher->seller_id = ($voucher->type == 'seller') ? $request->seller : null;
            $voucher->save();

            VoucherProduct::where('voucher_id', $voucher->id)->delete();

            if ($request->type == 'product') {
                if (!empty($request->products)) {
                    foreach ($request->products as $product) {
                        $voucherProduct = new VoucherProduct();
                        $voucherProduct->voucher_id = $voucher->id;
                        $voucherProduct->product_id = $product;
                        $voucherProduct->save();
                    }
                }
            }
            return redirect()->route('seller.vouchers.index')->with('success', 'Voucher updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $voucher = Voucher::find($id);
        if (!$voucher) {
            \Session::flash('error', 'No recored found');
        }
        VoucherProduct::where('voucher_id', $voucher->id)->delete();

        $voucher->delete();
        \Session::flash('success', 'Voucher removed successfully');
        return;
    }
}
