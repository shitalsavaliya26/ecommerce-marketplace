<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth,DB;
use App\Order;
use App\ShippingCompany;
use App\Product;
use App\Coupon;
use App\Helpers\NotificationHelper;
use App\CoinManagement;
use App\Notifications\OrderDelivered;
use App\Notifications\OrderRejected;
use App\Notifications\OrderShipped;
use App\OrderTrackingNumber;
use App\PushNotification;
use App\Transactionhistoriesagent;
use App\Transactionhistoriescustomer;
use App\Transactionhistoriesstaff;
use App\TransactionHistory;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Notification;
use Response;
use Session;

class OrderController extends Controller
{
    public function orders(Request $request){
        $seller = auth()->user()->seller;
        $seller_id = $seller ? $seller->id : 0;

        $allowed_sorts = ['name', 'created_at'];
        $searchQuery = $request->get('search');
        $user = Auth::user();
        $where = [];

        $data = $request->all();

        if (isset($data['status']) && $data['status'] != '') {
            $where[] = ['status', '=', $data['status']];
        }
        if ($request->get('fromDate') && $request->get('fromDate') != '') {
            $where[] = ['created_at', ">=", date("Y-m-d H:i:s", strtotime($request->get('fromDate')))];
        }
        if ($request->get('toDate') && $request->get('toDate') != '') {
            $where[] = ['created_at', "<=", date("Y-m-d 23:59:59", strtotime($request->get('toDate')))];
        }

        if (isset($data['courier_company_name']) && $data['courier_company_name'] != '') {
            $where[] = ['courier_company_name', '=', $data['courier_company_name']];
        }

        $orders = Order::with('user')->with('tracking_no')->with('counriercompanies')->with('shippingCompany')->with('orderAddress')->whereIn('role_id', [7])->where($where)->whereHas('user');
        $search = $request->search;
        if (isset($data['search']) && $data['search'] != '') {
            $searchTerm = $data['search'];
            $orders = $orders->where(function ($q) use ($searchTerm) {
                $q->where('order_id', $searchTerm);
                $q->orwhere('courier_company_name', 'like', '%' . $searchTerm . '%');
                $q->orwhere('tracking_number', '=', $searchTerm);
                $q->orwhere('remark', 'like', '%' . $searchTerm . '%');
                $q->orWhereHas('user', function ($q1) use ($searchTerm) {
                    $q1->where('name', 'Like', '%' . $searchTerm . '%');
                });
            });
        }
        $orders = $orders->whereHas('orderProduct',function($query) use ($seller_id){
            $query->whereHas('productdetail',function($query1) use ($seller_id){
                $query1->where('seller_id',$seller_id);
            });
        });
        $order_status_total = $orders->sum('total_amount');
        $orders = $orders->orderBy(DB::raw('case when status= "pending" then 1 when status= "shipped" then 2 when status= "delivered" then 3  when status= "rejected" then 4 when status= "cancelled"  then 5 end'))
        ->orderBy('created_at', 'DESC')->paginate(100);
        $orders->appends($request->all());
        $request->session()->put('customerorderfilter', $data);
        $shipping = ShippingCompany::where('status', '=', 'active')->where('is_deleted', '0')->get();
        return view('seller.order.list')->with('order_status_total', $order_status_total)->with('orders', $orders)->with("user", $user)->with("shipping", $shipping)->with($data)->render();
    }

    public function detail($id)
    {
        // $id = $request->orderId;
        $seller = auth()->user()->seller;
        $seller_id = $seller ? $seller->id : 0;

        $order = Order::with('orderProduct', 'orderProduct.attributeVariationPrice', 'orderProduct.productdetail.attributes', 'tracking_no', 'counriercompanies', 'shippingCompany')->where('order_id',$id)
                        ->whereHas('orderProduct',function($query) use ($seller_id){
                            $query->whereHas('productdetail',function($query1) use ($seller_id){
                                $query1->where('seller_id',$seller_id);
                            });
                        })
                        ->with(['orderProduct'=>function($query) use ($seller_id){
                            $query->with(['productdetail' => function($query1) use ($seller_id){
                                $query1->where('seller_id',$seller_id);
                            }]);
                        }])
                        ->first();
        // dd($order->orderProduct);
        if(!$order){
            return redirect()->route('seller.orders')->withErrors('You are not authorized to access this order');
        }
        $products = Product::select("id", "name")->where("is_deleted", "=", "0")->get();
        $shipping = ShippingCompany::where('status', '=', 'active')->where('is_deleted', '0')->get();
        $allproducts = Product::with(['images', 'productPrice'])
                            ->where('is_deleted', '0')
                            ->where('status', 'active')
                            ->get();

        $orderVoucherDiscount = $orderVoucherCashback = [];
        $sellerDiscount = $sellerCashback = 0;

        if($order->orderVouchers && count($order->orderVouchers) > 0){
            $orderVoucherDiscount = array_column((array)$order->orderVouchers, 'discount');
            $orderVoucherCashback = array_column((array)$order->orderVouchers, 'cashback');
            foreach($order->orderVouchers as $key) {
                $orderVoucherDiscount[] = $key["discount"];
                $orderVoucherCashback[] = $key["cashback"];
            }
            $sellerDiscount = array_sum($orderVoucherDiscount);
            $sellerCashback = array_sum($orderVoucherCashback);
        }
        return view('seller.order.detail')->with('products', $products)->with('order', $order)->with('shipping', $shipping)->with('allproducts', $allproducts)->with('sellerDiscount', $sellerDiscount)->with('sellerCashback', $sellerCashback)->render();
    }

    public function get_product_price($user_id, $product_id)
    {
        $price = 0;
        $user = User::find($user_id);
        $product = Product::find($product_id);
        $price = $product->customer_price;
        return $price;
    }

}
