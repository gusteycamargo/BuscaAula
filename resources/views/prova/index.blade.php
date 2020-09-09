@extends('templates.main', ['titulo' => "Menu", 'tag' => "MENU"])

@section('conteudo')
 
     <div class='row'>
         <div class='col-sm-12'>
            <button class="btn btn-primary btn-block">
                <b>Cadastrar Nova Prova</b>
            </button>
         </div>
     </div>
     <br>
 
     @component(
         'components.tablelist', [
             "header" => ['Descrição', 'Bimestre', 'Eventos'],
             "data" => $provas
         ]
     )
     @endcomponent

     <!--  -->
@endsection

