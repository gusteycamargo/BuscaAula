<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function __construct() {
        $this->middleware('auth:teacher');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'subject' => ['required'],
            'hour_initial' => ['required'],
            'hour_final' => ['required']
        ]);
    }

    public function home() {
        return view('main.main-teacher');
    }

    public function profile()
    {
        $teacher = Auth::user();
        if(isset($teacher)) {
            return view('teacher.show', compact(['teacher']));
        }
        return response('Professor nao encontrado', 404);
    }

    public function update(Request $request) {
        $teacherLogged = Auth::user();

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect('/myprofile')->withErrors( $validator )->withInput();
        }

        $teacher = Teacher::findOrFail($teacherLogged->id);
        if(isset($teacher)) {
            $teacher->name = $request->input('name');
            $teacher->email = $request->input('email');
            $teacher->subject_id = $request->input('subject');
            $teacher->hour_initial = $request->input('hour_initial');
            $teacher->hour_final = $request->input('hour_final');

            $teacher->update();

            return redirect()->intended(route('home-teacher'));
        }
        return response('Professor nao encontrado', 404);
    }
}
