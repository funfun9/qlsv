<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;

class checkGet
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
        $id = $request->id;
        $allroles = Role::all()->pluck('name')->toArray();
        $roleAuth = $userAuth->getRoleNames()[0];
        if($id){
            if(in_array($roleAuth, $allroles)){
                return $next($request);
            }
        }
        else{
            if(in_array($roleAuth, $allroles)){
                return $next($request);
            }
        }
    }
}
