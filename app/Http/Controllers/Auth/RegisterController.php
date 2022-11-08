<?php

namespace App\Http\Controllers\Auth;

use App\Cart;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\State;
use App\User;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/searchFilter';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function showRegistrationForm()
    {
        $states = State::select('id', 'name')->get();
        return view('auth.register', compact('states'));
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        // Remove this comment whenever client require otp verification
        // return redirect()->route('verifyOtp', Helper::encrypt($user->id)); 

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
        ? new JsonResponse([], 201)
        : redirect(session()->get('intendedurl'));
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            // "sponsor_country_code" => "required",
            "sponsor" => "required|min:6|max:11",
            "name" => "required|min:3|max:40",
            "phone" => "required|digits_between:9,11|unique:users",
            "country_code" => "required",
            "email" => "required|unique:users|min:6|max:40",
            "state" => "required",
            // "race" => "required",
            "password" => "required|min:6|max:30",
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // $userExist = User::where('phone',$request->phone)->where('is_deleted','0')->first();
        // if($userExist){
        //     return response::json(['success' => false, 'message' => 'phone number already exist', "code" => 400], 400);
        // }
        // $data = $request->all();
        $otp = rand(0000, 9999);
        $parent_agent = User::where('referal_code', $data['sponsor'])->first();
        if ($parent_agent != '') {
            $username = Helper::genrateusernamefromemail($data['email']);
            $email = strtolower($data['email']);
            $user = User::create([
                'name' => $data['name'],
                'email' => $email,
                'phone' => $data['phone'],
                'country_code' => $data['country_code'],
                // Remove comment whenever client need otp verificarion
                // 'status' => 'pending',
                'status' => 'active',
                'role_id' => 7,
                'rank_id' => 0,
                'is_deleted' => 0,
                'is_verify' => 0,
                'is_complete_profile' => 1,
                'parent_id' => $parent_agent->id,
                'refer_by' => $parent_agent->id,
                'referal_code' => Helper::refId($username),
                'username' => $username,
                "monthly_sales" => 0,
                'password' => bcrypt($data['password']),
                'device_type' => 'web',
                // 'race' => $data['race'],
                'state' => $data['state'],
                'gender' => $data['gender'],
                'otp' => $otp,
            ]);
            $cart = session()->get('cartItems');
            if (session()->has('cartItems') && count($cart) > 0) {
                foreach ($cart as $key => $item) {
                    $in_cart = Cart::where('product_id', $item['product_id'])
                        ->where('user_id', $user->id);
                    if ($item['variation_id'] != '') {
                        $in_cart = $in_cart->where('variation_id', $item['variation_id']);
                    }

                    $in_cart = $in_cart->first();
                    if (empty($in_cart)) {
                        $data = [
                            'user_id' => $user->id,
                            'product_id' => $item['product_id'],
                            'qty' => $item['qty'],
                            'seller_id' => $item['seller_id'],
                        ];
                        if ($item['variation_id'] != '') {
                            $data['variation_id'] = $item['variation_id'];
                        }
                        Cart::create($data);
                    } else {
                        $in_cart->qty = $in_cart->qty + $item['qty'];
                        $in_cart->save();
                    }

                }
                session()->forget('cartItems');
                \Session::flash('success', trans('messages.itenaddtocart'));
                return redirect()->route('viewcart');
            }
            return $user;
        }
    }

    /* check sponsor exist */
    public function sponsorUserExits(Request $request)
    {
        $isValid = false;
        $usernameExits = User::where('referal_code', $request->sponsor)->whereIn('role_id', [2, 3, 4, 5, 6, 15])->where('is_deleted', '0')->where('status', 'active')->first();

        if ($usernameExits) {
            $isValid = true;
        } else {
            $isValid = false;
        }
        echo json_encode(array(
            'valid' => $isValid,
        ));
    }

    public function genrateusernamefromemail($email)
    {
        $username = explode("@", $email);
        $username = $username[0];
        $count = User::where('username', 'like', "%" . $username . "%")->count();
        if ($count == 0) {
            return $username;
        } else {
            return $username . $count;
        }
    }

    private function refId($name)
    {
        $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
        $name = substr($name, 0, 3);
        return strtoupper($name . rand(100, 999));
    }

    public function verifyOtp($id)
    {
        return view('auth.otp', compact('id'));
    }

    public function confirmOtp(Request $request)
    {
        $userId = Helper::decrypt($request->userId);
        $user = User::find($userId);
        if ($user) {
            if ($user->otp == $request->otp) {
                $user->status = 'active';
                $user->otp = null;
                $user->update();
                $this->guard()->login($user);

                if ($response = $this->registered($request, $user)) {
                    return $response;
                }

                return $request->wantsJson()
                ? new JsonResponse([], 201)
                : redirect(session()->get('intendedurl'));
            } else {

                \Session::flash('error', 'OTP not matched');
                return redirect()->back();
            }
        }
    }
}
