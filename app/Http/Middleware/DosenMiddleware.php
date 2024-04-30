<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class DosenMiddleware
{

    public function handle(Request $request, Closure $next): Response{
        if(Auth::check()){
            if(Auth::user()->role_id == 2) {
                return $next($request);
            }else{
                return redirect('/dashboard')->with('message', 'access denied');
            }
        }else{
            return redirect('/login')->with('message', 'Login sebagai admin untuk melakukan access');
        }
        return $next($request);
    }

}
