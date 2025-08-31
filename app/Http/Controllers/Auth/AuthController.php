<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $otp_code=rand(100000, 999999);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone'=>$request->phone,
            'otp_code'=>$otp_code,
        ]);
        
        return response()->json(['message'=>__('You Regisered Successfully and your OTP Code is: '). $otp_code], 201);
    }

    public function verify_otp(VerifyRequest $request)
    {
        $user=User::where('phone',$request->phone)
                    ->where('otp_code',$request->otp_code)
                    ->first();
        if(!$user){
            return response()->json(__('Your OTP-Code Is Incorrect'));
        }
        $user->is_verified=true;
        $user->otp_code=null;
        $user->save();
        return response()->json(__('Your OTP-Code Is Correct, Login Now'));
    }
    public function login(LoginRequest $request)
    {
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json(__('Invalid Email or Password'), 403);
        }
        $user=User::where('email',$request->email)->firstOrFail();
        if($user->is_verified==false){
            return response()->json(__('Resend Your OTP Code'));
        }
        $token=$user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message'=>__('Login Successfully'),
            'user'=>$user,
            'token'=>$token
        ],201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete;
        return response()->json(__('Logout Successfully'));
    }
}
