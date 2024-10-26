<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class is_auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $access_token=$request->header('access_token');
        if(!$access_token){
            return response()->json([
                'msg'=>'access token is missing'
            ],400);
        }

        $user=User::where('access_token',$access_token)->first();
        if(!$user){
            return response()->json([
                'msg'=>'invalid access token'
            ],404);
        }

        Auth::setUser($user);
        return $next($request);
    }
    }

