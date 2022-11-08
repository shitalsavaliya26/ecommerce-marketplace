<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Order;
use App\Helpers\Helper;
use App\Product;
use App\Seller;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Response;

class IncomeReportController extends Controller
{
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

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
        $data = $request->all();
        $user = $this->userseller;
        $startDate = ($request->has('fromDate') && $request->fromDate != '') ? date('Y-m-d', strtotime($request->fromDate)) : '';
        $endDate = ($request->has('toDate') && $request->toDate != '') ? date('Y-m-d', strtotime($request->toDate)) : '';

        $sellerId = $this->user->seller->id;

        $orders = Order::select('id', 'order_id', DB::raw('date(created_at) as day'))->where('status', 'delivered')->whereHas('orderProduct', function ($q) use ($sellerId) {
            $q->where('seller_id', $sellerId);
        });

        if ($startDate != '' && $endDate != '') {
            $orders = $orders->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        }

        $orders = $orders->orderBy('id', 'DESC')->get()->groupBy(DB::raw("day"))->toArray();

        $i = 0;
        $date = [];
        $dayIncome = [];
        $totalOrder = 0;
        $totalAmount = 0;

        foreach($orders as $key => $graph){
            $orderIds = array_column($graph, 'id'); 
            $totalAmount += Helper::dateWiseOrderTotal($orderIds);
            $totalOrder += count($graph);
            $i++;
            $orderIds = array_column($graph, 'id'); 
            $total = Helper::dateWiseOrderTotal($orderIds);
            $date[] = $key;
            $dayIncome[] = $total;
            if (($startDate == '' || $endDate == '') && $i >30) {
                break;
            }
        }

        $request->session()->put('incomeorderfilter', $data);

        $orders = $this->paginate($orders);

        $best_selling_product_qty = Product::where('is_deleted', '=', '0')
                                            ->where('products.seller_id',$user->id)
                                            ->where('products.status',"active")
                                            ->leftJoin('order_products','products.id','=','order_products.product_id')
                                            ->leftJoin('orders','order_products.order_id','=','orders.id')
                                            ->whereIn('orders.status',['shipped','delivered']);
        if ($startDate != '' && $endDate != '') {
            $best_selling_product_qty = $best_selling_product_qty->whereDate('orders.created_at', '>=', $startDate)->whereDate('orders.created_at', '<=', $endDate);
        }
        $best_selling_product_qty = $best_selling_product_qty->selectRaw('products.*, COALESCE(sum(order_products.qty),0) total')
                                            ->groupBy('products.id')
                                            ->orderBy('total','desc')
                                            ->take(10)
                                            ->get()
                                            ->filter(function($item)
                                            {
                                                return ($item->total > 0);
                                            });

        $best_selling_product_sale = Product::where('is_deleted', '=', '0')
                                            ->where('products.seller_id',$user->id)
                                            ->where('products.status',"active")
                                            ->leftJoin('order_products','products.id','=','order_products.product_id')
                                            ->leftJoin('orders','order_products.order_id','=','orders.id')
                                            ->whereIn('orders.status',['shipped','delivered']);
        if ($startDate != '' && $endDate != '') {
            $best_selling_product_sale = $best_selling_product_sale->whereDate('orders.created_at', '>=', $startDate)->whereDate('orders.created_at', '<=', $endDate);
        }

        $best_selling_product_sale = $best_selling_product_sale->selectRaw('products.*, COALESCE(sum(order_products.qty * order_products.price)) total')
                                            ->groupBy('products.id')
                                            ->orderBy('total','desc')
                                            ->take(10)
                                            ->get()
                                            ->filter(function($item)
                                            {
                                                return ($item->total > 0);
                                            });

        return view('seller.myincome.list')->with('orders', $orders)->with($data)->with('date', $date)->with('dayIncome', $dayIncome)->with('best_selling_product_qty', $best_selling_product_qty)->with('best_selling_product_sale', $best_selling_product_sale)->with('totalOrder', $totalOrder)->with('totalAmount', $totalAmount);
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
}
