<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Curso;

class Cursos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = Curso::all();

        return view('curso.index', compact(['cursos']));
    }

    public function store(Request $request)
    {
        $novo = new Curso();
        $novo->nome = $request->input('nome');
        $novo->save();

        return json_encode($novo);
    }

    public function loadJson() {
        $cursos = Curso::all();
        return json_encode($cursos);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $curso = Curso::with('disciplina')->findOrFail($id);
        if(isset($curso)) {
            return json_encode($curso);
        }
        return response('Curso nao encontrado', 404);
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
        $curso = Curso::findOrFail($id);
        if(isset($curso)) {
            $curso->nome = $request->input('nome');
            $curso->save();

            return json_encode($curso);
        }
        return response('Curso nao encontrado', 404);
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
