<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class checkAdmin
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
        $idAuth = Auth::user()->id;
        $userAuth = User::find($idAuth);
        $permissionAuth = $userAuth->getAllPermissions()->pluck('name')->toArray();
        $requestName = $request->route()->getName();
        if($userAuth->hasRole("admin") || in_array($requestName, $permissionAuth)){
            return $next($request);
        }
        return response()->json(['Error'=> 'Not right role']);
        
    }
}