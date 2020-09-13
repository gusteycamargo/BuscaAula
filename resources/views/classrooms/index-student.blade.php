@extends('templates.main', ['titulo' => "Turmas", 'tag' => "DISCIPLINA"])

@section('conteudo')
 
     <br>
 
     <div class="justify-content-center align-itens-center row">
        @component(
            'components.tablelistMyclasses', [
                "header" => ['Nome'],
                "data" => $classes
            ]
        )
        @endcomponent
    </div>
@endsection
