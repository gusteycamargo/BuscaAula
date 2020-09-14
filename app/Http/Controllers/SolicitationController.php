<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitation;
use App\Teacher;
use App\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SolicitationController extends Controller
{
    public function store(Request $request)
    {
        $verify = Solicitation::where('teacher_id', $request->input('teacher_id'))->where('student_id', $request->input('student_id'))->first();

        if(isset($verify)) {
            return response('Já existe uma solicitação em aberto', 418);
        }

        $teacher = Teacher::findOrFail($request->input('teacher_id'));
        $student = Student::findOrFail($request->input('student_id'));

        if(isset($teacher) && isset($student)) {
            $solicitation = new Solicitation();
            $solicitation->teacher()->associate($teacher);
            $solicitation->student()->associate($student); 
            $solicitation->save();
    
            return json_encode($solicitation);
        }

        return response('Estudante ou professor nao encontrado, impossível realizar solicitação', 404);
    }

    public function solicitationsByTeacher(Request $request) {
        $teacher = Auth::user();

        if(isset($teacher)) {
            $solicitations = Solicitation::where('teacher_id', $teacher->id)->with('student')->get();

            return view('solicitations.index', compact(['solicitations']));
        }
        return response('Estudante nao encontrado', 404);
    }

    public function destroy($id)
    {
        $solicitation = Solicitation::findOrFail($id);
        if(isset($solicitation)) {
            $solicitation->delete();

            return json_encode($solicitation);
        }

        return response('solicitação nao encontrada', 404);
    }
}
