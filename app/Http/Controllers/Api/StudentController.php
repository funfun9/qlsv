<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function index()
    {
        $students = Student::all()->toArray();
        return array_reverse($students);
    }

    public function add(Request $request)
    {
        $student = new Student(['username' => $request->input('username'), 
                                'firstname' => $request->input('firstname'),
                                'lastname' => $request->input('lastname'),
                                'phone' => $request->input('phone'),
                                'email' => $request->input('email'),
                                'gender' => $request->input('gender'),
                                'identification' => $request->input('identification'),
                                'address' => $request->input('address'),
                                'school_id' => $request->input('school_id'),
                                'delete' => $request->input('delete'),
                                ]);
        $student->save();
        return response()->json('Student created!');
    }

    public function show($id)
    {
        $student = Student::find($id);
        return response()->json($student);
    }

    public function update($id, Request $request)
    {
        $student = Student::find($id);
        $student->update($request->all());
        return response()->json('Student updated!');
    }

    public function delete($id, Request $request)
    {
        $student = Student::find($id);
        $student->update($request->all());
        return response()->json('Student delete!');
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        $student->delete();
        return response()->json('Student detroy!');
    }
    
}
