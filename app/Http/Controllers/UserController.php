<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validate->fails()){
            return response()->json([
                'errors'=>$validate->errors()
            ],400);
        }

        $password=bcrypt($request->password);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>$password,
        ]);

        return response()->json([
            'status'=>'success',
            'data'=>$user
        ], 201);
    }

    public function login(Request $request)
    {
        $validate=Validator::make($request->all(),[
            'email'=>'required|email|max:255',
            'password'=>'required|string|min:8'
        ]);
        if($validate->fails()){
            return response()->json([
                'errors'=>$validate->errors()
            ],400);
        }
        $cred=['email'=>$request->email,'password'=>$request->password];

        if(Auth::attempt($cred)){
            Auth::user()->access_token=bin2hex(random_bytes(32));
            Auth::user()->save();
            return response()->json([
                'status'=>'success',
                'access_token'=>Auth::user()->access_token
            ],201);
        }else{
            return response()->json([
                'status'=>'failed',
                'msg'=>'wrong credintials'
            ],404);
        }
  }
}

