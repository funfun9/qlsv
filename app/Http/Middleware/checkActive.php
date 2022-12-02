<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        if(Auth::check()){
            $active = Auth::user()->active;
            $delete = Auth::user()->delete;
            if($active == "true" && $delete == "0"){
                return $next($request);
            }
            return response()->json(['Error'=> 'Not login']);
        }
        return response()->json(['Error'=> 'Not login']);
    }
}