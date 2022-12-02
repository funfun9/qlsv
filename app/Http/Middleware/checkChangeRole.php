<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class checkChangeRole
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
        $roleAuth = $userAuth->getRoleNames()->toArray();
        $role = $request->input('roles');
        $id = $request->id;

        if($role){
            if($idAuth == $id){
                
            }
        }
        return $next($request);
    }
}
