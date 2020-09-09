<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Disciplina;
use App\Curso;
use App\Professor;

class Disciplinas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disciplinas = Disciplina::with(['curso', 'professor'])->get();

        return view('disciplina.index', compact(['disciplinas']));
    }

    public function store(Request $request)
    {
        $curso = Curso::findOrFail($request->input('curso'));
        $professor = Professor::findOrFail($request->input('professor'));

        $novo = new Disciplina();
        $novo->nome = $request->input('nome');
        $novo->professor()->associate($professor);
        $novo->curso()->associate($curso); 
        $novo->save();

        return json_encode($novo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $disciplina = Disciplina::findOrFail($id);
        if(isset($disciplina)) {
            return json_encode($disciplina);
        }
        return response('Disciplina nao encontrada', 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $disciplina = Disciplina::findOrFail($id);
        $curso = Curso::findOrFail($request->input('curso'));
        $professor = Professor::findOrFail($request->input('professor'));

        if(isset($disciplina)) {
            $disciplina->nome = $request->input('nome');
            $disciplina->professor()->associate($professor);
            $disciplina->curso()->associate($curso); 

            $disciplina->save();
            return json_encode($disciplina);
        }
        return response('Disciplina nao encontrada', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
