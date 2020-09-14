<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\Teacher;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255']
        ]);
    }

    public function index() {
        $teachers = Teacher::all();

        return view('student.index', compact(['teachers']));
    }

    public function filter(Request $request) {
        if($request->input('subject') == null && $request->input('hour_initial') == null && $request->input('hour_final') == null) {
            $teachers = Teacher::all();

        }
        else {
            $teachers = Teacher::where(function ($query) use ($request) {
                                        if($request->input('subject')) {
                                            $query->where('subject_id', '=', $request->input('subject'));
                                        }
                                        if($request->input('hour_initial')) {
                                            $query->where('hour_initial', '>=', $request->input('hour_initial'));
                                        }
                                        if($request->input('hour_final')) {
                                            $query->where('hour_final', '<=', $request->input('hour_final'));
                                        }
                                    })->get();
        }

        return view('student.index', compact(['teachers']));
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
            return view('student.show', compact(['student']));
        }
        return response('Estudante nao encontrado', 404);
    }

    public function update(Request $request) {
        $studentLogged = Auth::user();

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect('/profile')->withErrors( $validator )->withInput();
        }

        $student = Student::findOrFail($studentLogged->id);
        if(isset($student)) {
            $student->name = $request->input('name');
            $student->email = $request->input('email');

            $student->update();

            return redirect('/profile');
        }
        return response('Professor nao encontrado', 404);
    }
}
