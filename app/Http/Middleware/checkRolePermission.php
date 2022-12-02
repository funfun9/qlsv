<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class checkRolePermission
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
        $role = $request->input('roles');
        $idAuth = Auth::user()->id;
        $userAuth = User::find($idAuth);
        $id = $request->id;
        $requestName = $request->route()->getName();
        
        if($id){
            $roleUser = User::find($id)->getRoleNames()->toArray();
            $permissionAuth = $userAuth->getAllPermissions()->pluck('name')->toArray();
            $roleAuth = $userAuth->getRoleNames()->toArray();
            if($userAuth->hasRole("admin") == true){
                return $next($request);
            }
            else {
                if($role){
                    if($roleAuth == $roleUser && in_array($role, $roleAuth)){
                        return $next($request);
                    }
                    return response()->json(['Error'=> 'Not right role']);
                }
                else{
                    if($roleAuth == $roleUser){
                        return $next($request);
                    }
                    return response()->json(['Error'=> 'Not right role']);
                }
            }
        }
        else{
            $roleAuth = $userAuth->getRoleNames()->toArray();
            if($userAuth->hasRole("admin") == true){
                return $next($request);
            }
            else {
                if($role){
                    if(in_array($role, $roleAuth)){
                        return $next($request);
                    }
                    return response()->json(['Error'=> 'Not right role']);
                }
                else{
                    return $next($request);              
                }
            }
        }
    }
}