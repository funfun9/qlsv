<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all()->toArray();
        return array_reverse($users);
    }

    public function add(Request $request)
    {
        $user = new User(['username' => $request->input('username'), 
                            'password' => $request->input('password'),
                            'firstname' => $request->input('firstname'),
                            'lastname' => $request->input('lastname'),
                            'phone' => $request->input('phone'),
                            'email' => $request->input('email'),
                            'gender' => $request->input('gender'),
                            'active' => $request->input('active'),
                            'delete' => $request->input('delete'),
                        ]);
        $user->save();
        return response()->json('User created!');
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $user->update($request->all());
        return response()->json('User updated!');
    }

    public function delete($id, Request $request)
    {
        $user = User::find($id);
        $user->update($request->all());
        return response()->json('User delete!');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json('User detroy!');
    }
    
    public function login(Request $request){	
		// Kiểm tra trong csdl
		$username = $request->input('username');
		$password = $request->input('password');
 
		if( Auth::attempt(['username' => $username, 'password' =>$password])) {
			// Kiểm tra đúng email và mật khẩu
			return response()->json('Login complete!');
		} else {
			// Kiểm tra không đúng sẽ hiển thị thông báo lỗi
			return response()->json('Email hoặc mật khẩu không đúng!!');
		}
	
    }

    public function logout() {
		Auth::logout();
	}
}
