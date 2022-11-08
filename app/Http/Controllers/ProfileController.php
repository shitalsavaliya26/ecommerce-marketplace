<?php

namespace App\Http\Controllers;

use App\Agentreceiver;
use App\Agentwithdrawrequest;
use App\Cart;
use App\GlobalSetting;
use App\Order;
use App\Product;
use App\ReviewRating;
use App\ReviewRatingImage;
use App\Rules\MatchOldPassword;
use App\Seller;
use App\Staffreceiver;
use App\Transactionhistoriescustomer;
use App\Transactionhistoriesagent;
use App\Transactionhistoriesstaff;

use App\UserAddress;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\UserVoucher;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
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
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($this->user->role_id == '7') {
            $addresses = UserAddress::where('user_id', $this->user->id)->get();

        } elseif ($this->user->role_id == '15') {
            $addresses = Staffreceiver::where('staff_id', $this->user->id)->where('is_deleted', '0')
                ->orderBy('address_for', 'DESC')
                ->where('address_for',1)
                ->orderBy('created_at', 'DESC')->get();
        } else {
            $addresses = Agentreceiver::where('agent_id', $this->user->id)->where('is_deleted', '0')
                ->orderBy('address_for', 'DESC')
                ->where('address_for',1)
                ->orderBy('created_at', 'DESC')->get();
        }

        $orders = Order::with('orderProduct')->whereHas('orderProduct')->with('orderProduct.productdetail')->whereHas('orderProduct.productdetail')->where('user_id', $this->user->id)->get();
        return view('profile.profile')->with('user', $this->user)->with('addresses', $addresses)->with('orders', $orders);
    }

    /* wallet */
    public function wallet(Request $request)
    {
        $user = Auth::user();
        if($user->role_id == 7){
            $transactionhistory = Transactionhistoriescustomer::where('user_id',$user->id)->whereIn('transaction_for',["payment","deposit"])->orderBy('created_at','desc')->paginate(10);
        }elseif($user->role_id == 15){
            $transactionhistory = Transactionhistoriesstaff::where('user_id',$user->id)->whereIn('transaction_for',["payment","deposit"])->orderBy('created_at','desc')->paginate(10);

        }else{
            $transactionhistory = Transactionhistoriesagent::where('user_id',$user->id)->whereIn('transaction_for',["payment","deposit"])->orderBy('created_at','desc')->paginate(10);
        }
        if ($request->ajax()) {
            return view('profile.orders.wallet', compact('transactionhistory'));
        }
        return view('profile.wallet')->with('user', $user)->with('transactionhistory', $transactionhistory);
    }

    /* add amount wallet */
    public function addamount(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'amount' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => 'Something went wrong!']);
        }
        if($user->role_id == 7){
            Transactionhistoriescustomer::create([
                'user_id' => $user->id,
                'order_id' => null,
                'status' => 'pending',
                'transaction_id' => uniqid(),
                'transaction_for' => "deposit",
                'amount' => round($request->amount),
                'payment_by' => '2',
            ]);
        }elseif($user->role_id == 15){
            Transactionhistoriesstaff::create([
                'user_id' => $user->id,
                'order_id' => null,
                'status' => 'pending',
                'transaction_id' => uniqid(),
                'transaction_for' => "deposit",
                'amount' => round($request->amount),
                'payment_by' => '2',
            ]);
        }else{
            Transactionhistoriesagent::create([
                'user_id' => $user->id,
                'order_id' => null,
                'status' => 'pending',
                'transaction_id' => uniqid(),
                'transaction_for' => "deposit",
                'amount' => round($request->amount),
                'payment_by' => '2',
            ]);
        }
        $user->increment('wallet_amount', $request->amount);
        return redirect()->back()->with('success', 'Amount added successfully.');
    }

    /* Withdraw PV Point */
    public function pvPointWithdraw(Request $request)
    {
        $user = Auth::user();

        $withdraws = Agentwithdrawrequest::where('user_id', $user->id)->orderby(DB::raw('case when status= "pending" then 1 when status= "accept" then 2 when status= "reject" then 2 end'))
            ->orderby('created_at', 'desc')
            ->paginate(10);
        return view('profile.withdraw')->with('user', $user)->with('withdraws', $withdraws);
    }

    /* Coin History */
    public function coinHistory(Request $request)
    {
        $user = Auth::user();

        $coinsHistory = Order::select('id', 'order_id', 'earned_coins', 'used_coins', 'created_at')->where('user_id', $user->id)->where(function ($q) {
            $q->where('used_coins', '>', 0)->orWhere('earned_coins', '>', 0);
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('profile.coinhistory')->with('user', $user)->with('coinsHistory', $coinsHistory);
    }

    /* add amount wallet */
    public function convertPvPoint(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'pv_point' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->pv_point > $user->pv_point) {
            return redirect()->back()->withErrors(['pv_point' => 'You do not have sufficient balance to complete this operation!'])->withInput();
        }

        $globalContent = GlobalSetting::where('key', 'convert_rm_point')->first();
        $percentage = $globalContent->value;

        $convertedRm = $request->pv_point * $percentage;
        $formatedRm = number_format($convertedRm, 2);

        if($user->role_id == 15){
            Transactionhistoriesstaff::create([
                'user_id' => $user->id,
                'order_id' => null,
                'status' => 'completed',
                'transaction_id' => uniqid(),
                'transaction_for' => "comission",
                'amount' => -$request->pv_point,
                'payment_by' => 0,
            ]);
        }else{
            Transactionhistoriesagent::create([
                'user_id' => $user->id,
                'order_id' => null,
                'status' => 'completed',
                'transaction_id' => uniqid(),
                'transaction_for' => "comission",
                'amount' => -$request->pv_point,
                'payment_by' => 0,
            ]);
        }
        
        $user->decrement('pv_point', $request->pv_point);
        $user->increment('wallet_amount', $formatedRm);

        return redirect()->back()->with('success', 'Request generated.');
    }

    public function walletWithdraw(Request $request){
        $user = Auth::user();
        if($user->role_id == 15){
            Transactionhistoriesstaff::create([
                'user_id' => $user->id,
                'account_number' => '',
                'bank_id' => 0,
                'name' => '',
                'amount' => $request->wallet_amount,
                'status' => "pending",
                'withdraw_request_from' => '2', //PV Points
            ]);
        }else{
            Agentwithdrawrequest::create([
                'user_id' => $user->id,
                'account_number' => '',
                'bank_id' => 0,
                'name' => '',
                'amount' => $request->wallet_amount,
                'status' => "pending",
                'withdraw_request_from' => '2', //PV Points
            ]);
        }
        
        $user->decrement('wallet_amount', $request->wallet_amount);
        return redirect()->back()->with('success', 'Request generated.');

    }
    /* orders */
    public function orders(Request $request)
    {
        $user = Auth::user();
        $orders = Order::with('orderProduct')->with('orderProduct.reviewrating')->whereHas('orderProduct')->with('orderProduct.productdetail')->whereHas('orderProduct.productdetail')->where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);
        if ($request->ajax() && $request->htype == 'all') {
            return view('profile.orders.all', compact('orders'));
        }

        /* topay */
        $user = Auth::user();

        $cart = Cart::wherehas('productdetails', function ($query) {
            $query->where('is_deleted', '0')
                ->where('status', "active");
        })->with('variation')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($item) {
                $item->variation_value = $item->variation;
                unset($item->variation);
                return $item;
            })->groupBy('seller_id');

        $amount = 0;
        $customer_amount = 0;
        $cartitem = [];
        $totalitems = 0;
        $product = null;
        $categoryProducts = [];
        foreach ($cart as $key => $item) {
            $seller = Seller::find($key);
            $result = [];
            $result['seller_id'] = ($seller) ? $seller->id : '';
            $result['seller_name'] = ($seller) ? $seller->name : '';

            foreach ($item as $cart_item) {

                $product = $cart_item->productdetails;
                $cart_item->productdetails->image = $cart_item->productdetails->image();
                $product_amount = $cart_item->getproductprice($user, $product->id, $cart_item->qty, $cart_item->variation_id);
                $product_amount = $product_amount * $cart_item->qty;
                $amount = $amount + $product_amount;
                $local = 'en';
                $cart_item->productdetails->name = $product->printproductname($local, $product->id);

                $cart_item->productdetails->customer_price = $product->getcustomerproductprice($user, $product->id, $cart_item->qty, $cart_item->variation_id);

                $customer_total = $cart_item->productdetails->customer_price * $cart_item->qty;
                $customer_amount = $customer_amount + $customer_total;
                $product = Product::find($cart_item->product_id);
                $cart_item->productdetails->cod = ($product->cod) ? 1 : 0;
                $cart_item->cod = ($product->cod) ? 1 : 0;
                $result['products'][] = $cart_item;
                $totalitems++;
            }

            $cartitem[] = $result;
        }

        $categories = [];
        $sameSellerProducts = [];
        if ($product) {
            $categories = $product->categories->pluck('category_id');

            $sameSellerProducts = Product::whereHas('categories')
                ->where('seller_id', $product->seller_id)
                ->inRandomOrder()
                ->limit(4)->get();

            if (count($categories) > 0) {
                $categoryProducts = Product::whereHas('categories', function ($query) use ($categories) {
                    $query->where('category_id', $categories);
                })->inRandomOrder()->limit(8)->get();
            } else {
                $categoryProducts = Product::where('name', 'like', '%' . $product->name . '%')->inRandomOrder()->limit(8)->get();
            }
        }
        $sub_total = $amount;

        $usedvariations = $cart = Cart::wherehas('productdetails')
            ->where('user_id', $user->id)->pluck('variation_id')->toArray();
        $topay = Order::with('orderProduct')->whereHas('orderProduct')->with('orderProduct.productdetail')->whereHas('orderProduct.productdetail')->where('user_id', $user->id)->where('status', 'pending_payment')->orderBy('created_at', 'desc')->paginate(10);
        if ($request->ajax() && $request->htype == 'pay') {
            return view('profile.orders.topay', compact('topay'));
        }
        $toship = Order::with('orderProduct')->whereHas('orderProduct')->with('orderProduct.productdetail')->whereHas('orderProduct.productdetail')->where('user_id', $user->id)->where('status', 'pending')->orderBy('created_at', 'desc')->paginate(10);
        if ($request->ajax() && $request->htype == 'ship') {
            return view('profile.orders.toship', compact('toship'));
        }
        $toreceive = Order::with('orderProduct')->whereHas('orderProduct')->with('orderProduct.productdetail')->whereHas('orderProduct.productdetail')->where('user_id', $user->id)->where('status', 'shipped')->orderBy('created_at', 'desc')->paginate(10);
        if ($request->ajax() && $request->htype == 'receive') {
            return view('profile.orders.toreceive', compact('toreceive'));
        }
        $complated = Order::with('orderProduct')->whereHas('orderProduct')->with('orderProduct.productdetail')->whereHas('orderProduct.productdetail')->where('user_id', $user->id)->where('status', 'delivered')->orderBy('created_at', 'desc')->paginate(10);
        if ($request->ajax() && $request->htype == 'complated') {
            return view('profile.orders.complated', compact('complated'));
        }
        $cancelled = Order::with('orderProduct')->whereHas('orderProduct')->with('orderProduct.productdetail')->whereHas('orderProduct.productdetail')->where('user_id', $user->id)->where('status', 'cancelled')->orderBy('created_at', 'desc')->paginate(10);
        if ($request->ajax() && $request->htype == 'cancelled') {
            return view('profile.orders.cancelled', compact('cancelled'));
        }

        $rejected = Order::with('orderProduct')->whereHas('orderProduct')->with('orderProduct.productdetail')->whereHas('orderProduct.productdetail')->where('user_id', $user->id)->where('status', 'rejected')->orderBy('created_at', 'desc')->paginate(10);
        if ($request->ajax() && $request->htype == 'rejected') {
            return view('profile.orders.rejected', compact('rejected'));
        }

        return view('profile.orders', compact('cartitem', 'amount', 'sameSellerProducts', 'categoryProducts', 'sub_total', 'totalitems', 'usedvariations', 'toship', 'toreceive', 'complated', 'cancelled', 'rejected', 'topay'))->with('user', $user)->with('orders', $orders);
    }

    public function uploadImage(Request $request)
    {
        $user = Auth::user();

        if ($request->image) {
            $originalmage = $user->image;
            $s3path = parse_url($originalmage);
            if (Storage::disk('s3')->exists($s3path['path'])) {
                Storage::disk('s3')->delete($s3path['path']);
            }
            $image = $request->file('image');
            $file_name = time() . '_profile.' . $image->getClientOriginalExtension();
            $path = "images/profile/" . $file_name;
            $upload = Storage::disk('s3')->put($path, file_get_contents($image), 'public');
            $fileURL = Storage::disk('s3')->url($path);
            $user->image = $fileURL;
            $user->save();
            return response()->json(['success' => 'done']);
        }
    }

    public function getAddress(Request $request)
    {
        if ($this->user->role_id == '7') {
            $address = UserAddress::find($request->addressId);
            if ($address) {
                return response()->json($address);
            }
        } elseif ($this->user->role_id == '15') {
            $address = Staffreceiver::find($request->addressId);
            if ($address) {
                return response()->json($address);
            }
        } else {
            $address = Agentreceiver::find($request->addressId);
            if ($address) {
                return response()->json($address);
            }
        }
        return response()->json(['success' => 'record not found!']);
    }

    public function updateAddress(Request $request)
    {
        if ($this->user->role_id == '7') {
            $address = UserAddress::find($request->address_id);
            if ($address) {
                $updatedData = array_column($request->postData, 'value', 'name');
                $address->name = $updatedData['name'];
                $address->country_code = $updatedData['country_code'];
                $address->contact_number = $updatedData['phone'];
                $address->address_line1 = $updatedData['address_line1'];
                $address->address_line2 = $updatedData['address_line2'] != '' ? $updatedData['address_line2'] : null;
                $address->postal_code = $updatedData['postal_code'];
                $address->town = $updatedData['town'];
                $address->state = $updatedData['state'];
                $address->country = 'Malaysia';
                $address->is_default = 'false';
                $address->save();
                return response()->json(['success' => 'Done!']);
            }
        } elseif ($this->user->role_id == '15') {
            $address = Staffreceiver::find($request->address_id);
            if ($address) {
                $updatedData = array_column($request->postData, 'value', 'name');
                $address->name = $updatedData['name'];
                $address->countrycode = $updatedData['country_code'];
                $address->contact_no = $updatedData['phone'];
                $address->address_line1 = $updatedData['address_line1'];
                $address->address_line2 = $updatedData['address_line2'] != '' ? $updatedData['address_line2'] : null;
                $address->postal_code = $updatedData['postal_code'];
                $address->town = $updatedData['town'];
                $address->state = $updatedData['state'];
                $address->country = 'Malaysia';
                $address->save();
                return response()->json(['success' => 'Done!']);
            }
        } else {
            $address = Agentreceiver::find($request->address_id);
            if ($address) {
                $updatedData = array_column($request->postData, 'value', 'name');
                $address->name = $updatedData['name'];
                $address->countrycode = $updatedData['country_code'];
                $address->contact_no = $updatedData['phone'];
                $address->address_line1 = $updatedData['address_line1'];
                $address->address_line2 = $updatedData['address_line2'] != '' ? $updatedData['address_line2'] : null;
                $address->postal_code = $updatedData['postal_code'];
                $address->town = $updatedData['town'];
                $address->state = $updatedData['state'];
                $address->country = 'Malaysia';
                $address->save();
                return response()->json(['success' => 'Done!']);
            }
        }
        return response()->json(['success' => 'record not found!']);
    }
    public function setDefaultAddress(Request $request)
    {
        if ($this->user->role_id == '7') {
            $updateUserAddress = UserAddress::where('id', '!=', $request->addressId)
                ->where('user_id', $this->user->id)
                ->update(['is_default' => 'false']);

            $setDefaultAddress = UserAddress::where('id', $request->addressId)
                ->where('user_id', $this->user->id)
                ->update(['is_default' => 'true']);
        } elseif ($this->user->role_id == '15') {
            $updateUserAddress = Staffreceiver::where('id', '!=', $request->addressId)
                ->where('staff_id', $this->user->id)
                ->update(['is_default' => 'false']);

            $setDefaultAddress = Staffreceiver::where('id', $request->addressId)
                ->where('staff_id', $this->user->id)
                ->update(['is_default' => 'true']);
        }else{
            $updateUserAddress = Agentreceiver::where('id', '!=', $request->addressId)
            ->where('agent_id', $this->user->id)
            ->update(['is_default' => 'false']);

            $setDefaultAddress = Agentreceiver::where('id', $request->addressId)
            ->where('agent_id', $this->user->id)
            ->update(['is_default' => 'true']);
        }
        return response()->json(['success' => 'done']);
    }

    public function addAddress(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'address_line1' => 'required',
            'state' => 'required',
            'town' => 'required',
            'postal_code' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => 'Something went wrong!']);
        } else {
            if ($this->user->role_id == '7') {
                $address = new UserAddress();
                $address->user_id = $this->user->id;
                $address->name = $request->name;
                $address->contact_number = $request->phone;
                $address->address_line1 = $request->address_line1;
                $address->address_line2 = $request->address_line2 != '' ? $request->address_line2 : null;
                $address->country = 'Malaysia';
                $address->state = $request->state;
                $address->country_code = $request->country_code;
                $address->town = $request->town;
                $address->postal_code = $request->postal_code;
                $address->is_default = 'false';
                $address->save();
            } elseif ($this->user->role_id == '15') {
                $address = new Staffreceiver();
                $address->staff_id = $this->user->id;
                $address->name = $request->name;
                $address->contact_no = $request->phone;
                $address->address_line1 = $request->address_line1;
                $address->address_line2 = $request->address_line2 != '' ? $request->address_line2 : null;
                $address->country = 'Malaysia';
                $address->state = $request->state;
                $address->countrycode = $request->country_code;
                $address->town = $request->town;
                $address->postal_code = $request->postal_code;
                $address->save();
            } else {
                $address = new Agentreceiver();
                $address->agent_id = $this->user->id;
                $address->name = $request->name;
                $address->contact_no = $request->phone;
                $address->address_line1 = $request->address_line1;
                $address->address_line2 = $request->address_line2 != '' ? $request->address_line2 : null;
                $address->country = 'Malaysia';
                $address->state = $request->state;
                $address->countrycode = $request->country_code;
                $address->town = $request->town;
                $address->postal_code = $request->postal_code;
                $address->save();
            }

            return response()->json(['success' => 'done']);
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        $user = Auth::user()->update(['password' => Hash::make($request->new_password)]);

        return \Redirect::route('user.profile')->with('message', 'Password change successfully!');
    }

    public function deleteAddress(Request $request)
    {
        if ($this->user->role_id == '7') {
            $userAddress = UserAddress::find($request->addressId);
            if ($userAddress) {
                $userAddress->delete($userAddress->id);
                return response()->json(['success' => 'done']);
            }
        } elseif ($this->user->role_id == '15') {
            $userAddress = Staffreceiver::find($request->addressId);
            if ($userAddress) {
                $userAddress->is_deleted = '1';
                $userAddress->update();
                return response()->json(['success' => 'done']);
            }
        } else {
            $userAddress = Agentreceiver::find($request->addressId);
            if ($userAddress) {
                $userAddress->is_deleted = '1';
                $userAddress->update();
                return response()->json(['success' => 'done']);
            }
        }
        return response()->json(['error' => 'something went wrong']);
    }

    public function editProfile(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $rules = [
            'email' => 'required_if:type,==,email|email',
            'phone' => 'required_if:type,==,phone|numeric|digits_between:9,13',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),

            ), 400);
        } else {
            if ($request->has('type') && $data['type'] == 'email') {
                $user->email = $data['email'];
            }
            if ($request->has('type') && $data['type'] == 'phone') {
                $user->phone = $data['phone'];
            }
            if ($request->has('gender')) {
                $user->gender = $data['gender'];
            }
            if ($request->has('race')) {
                $user->race = $data['race'];
            }
            if ($request->has('name')) {
                $user->name = $data['name'];
            }
            $user->save();
            return response()->json(['success' => 'done']);
        }
    }

    public function submitReview(Request $request)
    {
        $rating = ReviewRating::where('order_product_id', $request->orderProductId)->first();
        if ($rating) {
            $rating->rate = $request->rate;
            $rating->description = $request->description != '' ? $request->description : null;
            $rating->save();

            $image = $request->form['file'];

            if ($image) {
                foreach ($image as $file) {
                    $image_parts = explode(";base64,", $file);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = key_exists(1, $image_type_aux) ? $image_type_aux[1] : time();
                    $image_base64 = base64_decode($image_parts[1]);
                    $renamed = time() . rand() . '.' . $image_type;
                    $path = "images/review/" . $renamed;
                    $upload = Storage::disk('s3')->put($path, $image_base64, 'public');
                    $fileURL = Storage::disk('s3')->url($path);

                    $ratingImage = new ReviewRatingImage();
                    $ratingImage->review_rating_id = $rating->id;
                    $ratingImage->image = $fileURL;
                    $ratingImage->save();
                }
            }
            return response()->json(['success' => 'done']);
        } else {
            $rating = new ReviewRating();
            $rating->order_product_id = $request->orderProductId;
            $rating->product_id = $request->productId;
            $rating->user_id = Auth::user()->id;
            $rating->rate = $request->rate;
            $rating->description = $request->description != '' ? $request->description : null;
            $rating->save();

            $image = $request->form['file'];

            if ($image) {
                foreach ($image as $file) {
                    $image_parts = explode(";base64,", $file);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = key_exists(1, $image_type_aux) ? $image_type_aux[1] : time();
                    $image_base64 = base64_decode($image_parts[1]);
                    $renamed = time() . rand() . '.' . $image_type;
                    $path = "images/review/" . $renamed;
                    $upload = Storage::disk('s3')->put($path, $image_base64, 'public');
                    $fileURL = Storage::disk('s3')->url($path);

                    $ratingImage = new ReviewRatingImage();
                    $ratingImage->review_rating_id = $rating->id;
                    $ratingImage->image = $fileURL;
                    $ratingImage->save();
                }
            }
            return response()->json(['success' => 'done']);
        }
    }

    /* vouchers */
    public function myVouchers(Request $request)
    {
        $user = Auth::user();

        $myVouchers = UserVoucher::where('user_id', $user->id)->where('status',0)->orderBy('created_at','desc')->get();
        // dd($user->id);
        return view('profile.myVouchers')->with('myVouchers', $myVouchers);
    }

}
