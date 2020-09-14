@extends('templates.main', ['titulo' => "Turmas", 'tag' => "DISCIPLINA"])

@section('conteudo')
 
     <br>
 
     <div class="justify-content-center align-itens-center row">
        @component(
            'components.tablelistMyclasses', [
                "header" => ['Nome', 'Sair da turma'],
                "data" => $classes
            ]
        )
        @endcomponent
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        function deleteRegistration(id) {
            $.ajax({
                type: "DELETE",
                url: "/api/registration/"+id,
                context: this,
                success: function (data) {
                    $("#"+id+"reg").remove();
                
                    alert('Você saiu da turma!')
                },
                error: function(error) {
                    alert('ERRO AO SAIR TURMA');
                }
            })
        }
    </script>

@endsection


