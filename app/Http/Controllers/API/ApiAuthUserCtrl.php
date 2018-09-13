<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use JWTAuth;

use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\Events\Registered;


// use Aloha\Twilio\Support\Laravel\Facade;

class ApiAuthUserCtrl extends Controller
{
    use AuthenticatesUsers, RegistersUsers {
        AuthenticatesUsers::redirectPath insteadof RegistersUsers;
        AuthenticatesUsers::guard insteadof RegistersUsers;
    }

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('name', 'password');
        $user = Admin::where(['name' => $request->name])->first();
        if($user) {
            if ($user->enabled == false) {
                return response()->json(['message' => 'Your account has been blocked', 'data' => null, 'response_code' => 0], 500);
            }
        }

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'invalid_credentials', 'data' => null, 'response_code' => 0], 200);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['message' => 'could_not_create_token', 'data' => null, 'response_code' => 0], 500);
        }
        
        return response()->json(['message' => 'successfully login and user is verified', 'response_code' => 1,
                    'user' => Admin::where(['name' => $request->name])->first(), 'token'=>$token], 200);
    }
}
