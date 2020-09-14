<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Classroom;
use App\Registration;
use App\Teacher;
use App\Solicitation;
use Illuminate\Support\Facades\Auth;
use App\Events\RegistrationEvent;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {        
        $student = Student::findOrFail($request->student_id);
        $class = Classroom::findOrFail($request->classroom_id);
        $solicitation = Solicitation::findOrFail($request->solicitation_id);

        if(isset($student) && isset($class) && isset($solicitation)) {
            $registration = new Registration();
            $registration->student()->associate($student);
            $registration->classroom()->associate($class);
            $registration->save();

            $solicitation->delete();

            $teacher = Teacher::findOrFail($class->teacher_id);
            event(new RegistrationEvent($teacher, $student, $class));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function classesWithStudentLogged() {
        // $teacher = Auth::user();
        $classes = Registration::where('student_id', Auth::user()->id)->with('classroom')->get();

        //return json_encode($classes);
        return view('classrooms.index-student', compact(['classes']));
    }
}
