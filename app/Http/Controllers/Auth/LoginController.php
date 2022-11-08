<?php

namespace App\Http\Controllers\Auth;

use App\Cart;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /* login using phone */
    public function showLoginWithPhone(Request $request)
    {
        return view('auth.loginphone');
    }

    /* login */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $cart = session()->get('cartItems');

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }
            $user = Auth::user();
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
                $request->session()->forget('cartItems');
                \Session::flash('success', trans('messages.itenaddtocart'));
                return redirect()->route('viewcart');
            }
            return redirect()->intended($request->session()->get('intendedurl'));

            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function attemptLogin(Request $request)
    {
        // $request->merge(['role_id' => '7']);
        $user = [];
        if ($request->has('phone')) {
            $user = User::where('phone', $request->phone)->whereIn('role_id', ['2', '3', '4', '5', '6', '7', '15'])->where('is_deleted', '0')->first();
        } else {
            $user = User::where('email', $request->email)->whereIn('role_id', ['2', '3', '4', '5', '6', '7', '15'])->where('is_deleted', '0')->first();
        }
        if ($user) {
            return $this->guard()->attempt(
                $this->credentials($request), $request->filled('remember')
            );
        }
    }

    protected function credentials(Request $request)
    {
        if ($request->has('phone')) {
            return $request->only($this->phone(), 'password', 'country_code');
        } else {
            return $request->only($this->username(), 'password');
        }
    }

    protected function validateLogin(Request $request)
    {
        if ($request->has('phone')) {
            $request->validate([
                $this->phone() => 'required|string',
                'country_code' => 'required',
                'password' => 'required|string',
            ]);
        } else {
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]);
        }
    }

    public function phone()
    {
        return 'phone';
    }
}
