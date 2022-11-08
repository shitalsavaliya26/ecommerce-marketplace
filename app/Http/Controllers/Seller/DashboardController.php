<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Seller;
use App\Order;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /* todo list */
        $user   = Seller::where('user_id',Auth::user()->id)->first();
        $unpaid = Order::whereHas('orderProduct',function($query) use ($user){
                            $query->whereHas('productdetail', function($query1) use ($user){
                                $query1->where('seller_id',$user->id);
                            });
                        })
                        ->where('status', 'pending_payment')
                        ->count();

        $toprocessship = Order::whereHas('orderProduct',function($query) use ($user){
                                $query->whereHas('productdetail', function($query1) use ($user){
                                    $query1->where('seller_id',$user->id);
                                });
                            })
                            ->where('status', 'pending')
                            ->count();
                            // dd($toprocessship);
        $shipped = Order::whereHas('orderProduct',function($query) use ($user){
                            $query->whereHas('productdetail', function($query1) use ($user){
                                $query1->where('seller_id',$user->id);
                            });
                        })
                        ->where('status', 'shipped')
                        ->count();

        $cancelled = Order::whereHas('orderProduct',function($query) use ($user){
                            $query->whereHas('productdetail', function($query1) use ($user){
                                $query1->where('seller_id',$user->id);
                            });
                        })
                        ->where('status', 'cancelled')
                        ->count();

        $rejected = Order::whereHas('orderProduct',function($query) use ($user){
                            $query->whereHas('productdetail', function($query1) use ($user){
                                $query1->where('seller_id',$user->id);
                            });
                        })
                        ->where('status', 'rejected')
                        ->count();

        return view('seller.dashboard',compact('unpaid','toprocessship','shipped','cancelled','rejected'));
    }
}
