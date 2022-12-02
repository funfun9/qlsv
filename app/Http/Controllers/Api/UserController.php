<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\QueryException;


class UserController extends Controller
{

    public function index(Request $request)
    {
            $id = Auth::user()->id;
            $users = User::with("roles:name")->where('delete','0')
                                            ->where('id', '!=', $id )
                                            ->orderBy("id", "DESC");
            if($request -> has('username')){
                $users->where('username', 'like', '%' . $request -> username . '%');
            }
            if($request -> has('firstname')){
                $users->where('firstname', 'like', '%' . $request -> firstname . '%');
            }
            if($request -> has('lastname')){
                $users->where('lastname', 'like', '%' . $request -> lastname . '%');
            }
            if($request -> has('phone')){
                $users->where('phone', 'like', '%' . $request -> phone . '%');
            }
            if($request -> has('email')){
                $users->where('email', 'like', '%' . $request -> email . '%');
            }
            if($request -> has('gender')){
                $users->where('gender', 'like', '%' . $request -> gender . '%');
            }  
            if($request -> has('active')){
                $users->where('active', 'like', '%' . $request -> active . '%');
            }  
            return $users->paginate(5);
    }
    public function show($id)
    {
        $user = User::where("id", "=" , $id)->first();
        return $user;
    }

    public function updateActive($id){
        $userupdate = User::find($id);
        if($userupdate->active == "false"){
            $userupdate -> update(['active' => "true",
                                'updated_by' => Auth::user()->username
                                ]);
            return response()->json('update true');
        }
        $userupdate -> update(['active' => "false",
                                'updated_by' => Auth::user()->username
                            ]);
        return response()->json('update false');
    }

    public function add(Request $request)
    {
        try{
            $useradd = new User(['username' =>  $request->input('username'), 
                                    'password' => bcrypt($request->password),
                                    'firstname' => $request->input('firstname'),
                                    'lastname' => $request->input('lastname'),
                                    'phone' => $request->input('phone'),
                                    'email' => $request->input('email'),
                                    'gender' => $request->input('gender'),
                                    'active' => "false",
                                    'delete' => "0",
                                    'created_by' => Auth::user()->username,
                                    'updated_by' => null
                                ]);
                            $role = $request->input('roles');
                            if($role == 'admin' || $role == 'teacher')
                            {
                                $role = $request->input('roles');
                                $useradd->save();
                                $useradd->assignRole($role);
                                return response()->json('Created!');
                            }
                            else{
                                $useradd->save();
                                $useradd->assignRole('teacher');
                                return response()->json('Created!');               
                            }
        }
        catch (QueryException $exception) {
            return response()->json(['Error'=>'Username exists']);
            return response()->json($exception);
        }
    }

    public function update($id, Request $request)
    {
        $role = $request->input('roles');
        // $permission = $request->input('permissions');
        if($role == 'admin' || $role == 'teacher')
        {
            $userupdate = User::find($id);
            $userupdate -> update($request->except("username"));
            $userupdate -> update(['updated_by' => Auth::user()->username]);
            $userupdate->syncRoles($role);
            // $userupdate->givePermissionTo($permission);
            // $userupdate->syncRoles($role);
            return response()->json('Updated!');
        }
        else{
            $userupdate = User::find($id);
            $userupdate -> update($request->except("username"));
            $userupdate -> update(['updated_by' => Auth::user()->username]);
                                    // $userupdate->givePermissionTo($permission);
                                    return response()->json('Updated not roles!');                     
        }
    }

    public function delete($id)
    {
            $idAuth = Auth::user()->id;
            $user = User::find($id);
            if($idAuth != $id) {
                $user->update(["delete" => "1", 
                                "active" => "false",
                        "deleted_by"=>Auth::user()->username]);
                return response()->json('User delete!');
            }
            return response()->json(['Error'=>'Not delete your account']);
    }

    // -------------------LOGIN -------------------------------
    
    public function login(Request $request){	
		// Kiểm tra trong csdl
		$username = $request->input('username');
		$password = $request->input('password');

        // dd(Hash::make($password));

		if( Auth::attempt(['username' => $username, 'password' =>$password, 'delete' => '0', 'active' => 'true'])) {
                $validator = request(["username", "password"]);
                $token = JWTauth::attempt($validator); 
                
                return $this->newToken($token);  
		}
        if( Auth::attempt(['username' => $username, 'password' =>$password, 'delete' => '0', 'active' => 'false'])) {
            return response()->json(['Error' => 'Account not active']);
        }
        if( Auth::attempt(['username' => $username, 'password' =>$password, 'delete' => '1', 'active' => 'false'])) {
            return response()->json(['Error' => 'Account not active']);
        }
        return response()->json(['Error' => 'Username or Password not valid']);
    }

    public function userProfile(){
        return response()->json(auth()->user());
    }
    public function profileUpdate(Request $request)
    {
                    $id = Auth::user()->id;
                    $user = User::find($id);
                    $user -> update($request->except("username"));
                    $user -> update(['updated_by' => Auth::user()->username]);
                    return response()->json($user);
    }

    public function refresh() {
        $refresh = Auth::refresh();
        return $this->newToken($refresh);
    }

    public function register(Request $request) {
        try{
            $user = new User(['username' =>  $request->input('username'), 
                        'password' => bcrypt($request->password),
                        'active' => "false",
                        'delete' => "0",
            ]);
            $role = $request->input('roles');
            $user->assignRole($role);
            $user->save();
            return response()->json($user);
        }
            catch (QueryException $exception) {
                return response()->json(['Error'=>'Username exists']);
                return response()->json($exception);
            }
}

    protected function newToken($token){
        return response()->json([
            'accessToken' => $token,
        ]);
    }
    public function logout() {
        Auth::logout();
        return response()->json('Logout!');
	}
}