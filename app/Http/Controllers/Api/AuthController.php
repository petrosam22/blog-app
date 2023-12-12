<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(UserRequest $request){

        $user = User::create([
            'name'=> $request->name ,
            'email'=> $request-> email,
            'password'=> Hash::make($request->password) ,
        ]);


        $token = $user->createToken('API Token')->accessToken;

        return response([
         'user' => $user,
         'token' => $token
        ]);


    }

    public function login(Request $request){

        if(Auth::attempt(['email'=>$request->email ,'password'=>$request->password ])){
        $user = User::where('id',Auth::user()->id)->first();
        $accessToken = $user->createToken('Api-Token')->accessToken;
        return response()->json([
        'access_token' => $accessToken,
        'user' =>$user,

        ], 200);

        }else{
            return[
                'error' => 'Email or password is incorrect.',
            ];

        }
    }


    public function logout(){
        $user = User::where('id',Auth::user()->id)->first();


   $user->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);

      }
}
