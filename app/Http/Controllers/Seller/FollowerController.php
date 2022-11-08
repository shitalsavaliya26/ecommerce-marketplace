<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Seller;
use App\SellerFollower;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Response;

class FollowerController extends Controller
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
        $sellerId = Auth::user()->seller->id;
        $followers = SellerFollower::where('seller_id', $sellerId)->orderBy('id', 'DESC')->paginate(10);
        return view('seller.follower.list')->with('followers', $followers);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $follower = SellerFollower::find($id);
        if (!$follower) {
            \Session::flash('error', 'No recored found');
        }
        $follower->delete();
        \Session::flash('success', 'Follower removed successfully');
        return;
    }
}
