
 @extends('templates.default', ['titulo' => "Menu", 'tag' => "HOME"])
 @section('titulo') <b>Menu</b> @endsection
 @section('conteudo')
 
     <div class='row'>
        <div class="col-sm-3" style="text-align: center">
            <a href="{{ route('subjects.index') }}">
                <img style="width: 128px; height: 128px; margin-bottom: 5px" src="{{ asset('img/curso_ico.png') }}">
            </a>
            <h3>
                <b>Matérias</b>
            </h3>
        </div>
        <div class="col-sm-3" style="text-align: center">
            <a href="{{ route('solicitations') }}">
                <img style="width: 128px; height: 128px; margin-bottom: 5px" src="{{ asset('img/add_people_ico.png') }}">
            </a>
            <h3>
                <b>Solicitações</b>
            </h3>
        </div>
        <div class="col-sm-3" style="text-align: center">
            <a href="{{ route('classroom') }}">
                <img style="width: 128px; height: 128px; margin-bottom: 5px" src="{{ asset('img/disciplina_ico.png') }}">
            </a>
            <h3>
                <b>Turmas</b>
            </h3>
        </div>
       
     </div>
     <br>
@endsection