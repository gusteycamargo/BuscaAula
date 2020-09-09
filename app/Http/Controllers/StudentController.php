<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\Teacher;

class StudentController extends Controller
{


    public function index() {
        $teachers = Teacher::all();

        return view('teacher.index', compact(['teachers']));
    }

    public function filter(Request $request) {
        if($request->input('subject') == null && $request->input('name') == null) {
            $teachers = Teacher::all();
        }
        else {
            $teachers = Teacher::where('subject_id', $request->input('subject'))->orWhere('name', $request->input('name'))->get();
        }

        return view('teacher.index', compact(['teachers']));
    }

    public function showTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        if(isset($teacher)) {
            return json_encode($teacher);
        }
        return response('Professor nao encontrado', 404);
    }

    
    public function profile()
    {
        $student = Auth::user();
        if(isset($student)) {
            return view('student.index', compact(['student']));
        }
        return response('Estudante nao encontrado', 404);
    }
}
