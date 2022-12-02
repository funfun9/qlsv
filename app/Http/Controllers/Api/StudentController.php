<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class StudentController extends Controller
{

    public function index(Request $request)
    {
            $students = DB::table('students')->where('delete','0')->orderBy("id", "DESC");
            if($request -> has('username')){
                $students->where('username', 'like', '%' . $request -> username . '%');
            }
            if($request -> has('firstname')){
                $students->where('firstname', 'like', '%' . $request -> firstname . '%');
            }
            if($request -> has('lastname')){
                $students->where('lastname', 'like', '%' . $request -> lastname . '%');
            }
            if($request -> has('phone')){
                $students->where('phone', 'like', '%' . $request -> phone . '%');
            }
            if($request -> has('email')){
                $students->where('email', 'like', '%' . $request -> email . '%');
            }
            if($request -> has('gender')){
                $students->where('gender', 'like', '%' . $request -> gender . '%');
            }
            return $students->paginate(5);
    }

    public function add(Request $request)
    {
        try{
                $student = new Student(['username' => $request->input('username'),
                                        'firstname' => $request->input('firstname'),
                                        'lastname' => $request->input('lastname'),
                                        'phone' => $request->input('phone'),
                                        'email' => $request->input('email'),
                                        'gender' => $request->input('gender'),
                                        'identification' => $request->input('identification'),
                                        'address' => $request->input('address'),
                                        'school_id' => $request->input('school_id'),
                                        'delete' => "0",
                                        'created_by' => Auth::user()->username
                                    ]);
                                        $student->save();
                                        return response()->json('Student created!');
                                    }
                                    catch (QueryException $exception) {
                                        return response()->json(['Error'=>'Username exists']);
                                        return response()->json($exception);
                                    }       
    }

    public function show($id)
    {
        $student = Student::find($id);
        return response()->json($student);
    }

    public function update($id, Request $request)
    {
        $student = Student::find($id);
        $student -> update($request->except("username"));
        $student -> update(['updated_by' => Auth::user()->username]);
        return response()->json($student);
    }

    public function delete($id)
    {
        $student = Student::find($id);
        $student->update(["delete" => "1",
                            "deleted_by"=>Auth::user()->username]);
        return response()->json('Student delete!');
    }
    
}