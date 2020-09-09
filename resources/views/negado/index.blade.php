@extends('templates.main', ['titulo' => "Restrito", 'tag' => "NEGADO"])

@section('conteudo')

     <div class="d-flex justify-content-center align-items-center flex-column">
        <h1>Acesso restrito</h1>
        <img class="mt-4" width="200px" height="200px" src="{{ asset('img/negado.png') }}">
     </div>

     <br>
 
     
@endsection
