<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;

class SubjectController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:subjects'],
        ]);
    }

    public function index()
    {
        $subjects = Subject::all();
        return view('subject.index', compact(['subjects']));
    }

    public function loadJson()
    {
        $subjects = Subject::all();
        return json_encode($subjects);
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect('/subjects')->withErrors( $validator )->withInput();
        }

        $subject = new Subject();
        $subject->name = $request->input('name');
        $subject->save();

        return json_encode($subject);
    }

    public function show($id)
    {
        $subject = Subject::findOrFail($id);
        if(isset($subject)) {
            return json_encode($subject);
        }
        return response('Matéria nao encontrada', 404);
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        if(isset($subject)) {
            $subject->name = $request->input('name');
            $subject->save();

            return json_encode($subject);
        }
        return response('Matéria nao encontrada', 404);
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        if(isset($subject)) {
            $subject->delete();

            return json_encode($subject);
        }
        return response('Matéria nao encontrada', 404);
    }
}
