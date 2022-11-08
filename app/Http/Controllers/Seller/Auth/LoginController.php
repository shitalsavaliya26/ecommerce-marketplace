<?php

namespace App\Http\Controllers\Seller\Auth;

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
    protected $redirectTo = '/seller';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     public function showLoginForm()
    {
        return view('seller.auth.login');
    }

    /* login using phone */
    public function showLoginWithPhone(Request $request)
    {
        return view('seller.auth.loginphone');
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
            
            return redirect()->intended($request->session()->get('intendedsellerurl'));

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
            $user = User::where('phone', $request->phone)->whereIn('role_id', ['16'])->where('is_deleted', '0')->first();
        } else {
            $user = User::where('email', $request->email)->whereIn('role_id', ['16'])->where('is_deleted', '0')->first();
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

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/seller/login');
    }

     protected function loggedOut(Request $request)
    {
        //
    }
}
