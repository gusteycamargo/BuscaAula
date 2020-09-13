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
        $teacher = Teacher::findOrFail($request->input('teacher_id'));
        $student = Student::findOrFail($request->input('student_id'));

        $solicitation = new Solicitation();
        $solicitation->teacher()->associate($teacher);
        $solicitation->student()->associate($student); 
        $solicitation->save();

        return json_encode($solicitation);
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
