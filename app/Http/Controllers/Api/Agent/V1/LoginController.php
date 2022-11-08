<?php

namespace App\Http\Controllers\Api\Agent\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        $customerrole = ['7', '1'];

        $user = User::where('email', '=', $request->email)->whereNotIn('role_id', $customerrole)
                    ->where('role_id', '<', '7')->where('is_deleted', '0');

        if($user->count()) {
            $user = $user->first();
            
            if(Hash::check($request->password, $user->password)) {
                try { 
                    if (! $token = JWTAuth::fromUser($user)) { 
                        return response()->json(['success' => false, 'message' => 'You have entered an invalid email or password', "code" => 401], 401);
                    } 
                } catch (JWTException $e) { 
                    return response()->json(['success' => false, 'message' => 'Could not create token', "code" => 500], 500);
                } 
                //Token created, return with success response and jwt token

                $data = [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "username" => $user->username,
                    "country_code" => $user->country_code,
                    "phone" => $user->phone,
                    "reporting_head" => ($user->parent) ? $user->parent->name : '',
                    "referal_code" => $user->referal_code,
                    "current_rank" => $user->role ? $user->role->name : '',
                    "status" => $user->status,
                    "address_line1" => $user->address_line1,
                    "address_line2" => $user->address_line2,
                    "state" => $user->state,
                    "town" => $user->town,
                    "postal_code" => $user->postal_code,
                    "country" => $user->country,
                ];

                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'data' => $data
                ]);
            }else{
                return response()->json(['success' => false, 'message' => 'You have entered an invalid email or password', "code" => 401], 401);
            }
        }else{
            return response()->json(['success' => false, 'message' => 'user not found!', "code" => 500], 500);
        }
    }
}
