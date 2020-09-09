@extends('templates.main', ['titulo' => "Professores", 'tag' => "PROFESSOR"])

@section('conteudo')
 
     <div >
        <form class='row justify-content-center' method="POST" action="{{ route('filter') }}">
            @csrf
            <div class='col-sm-3'>
                <input id="name" type="text" class="form-control" name="name" autocomplete="name" autofocus>
            </div>
            <div class='col-sm-3'>
                <select name="subject" id="subject" class="form-control">
                    <option></option>
                </select>
            </div>
            <div class='col-sm-2'>
                <button class="btn btn-primary btn-block" type="submit">
                    <b>Filtrar professores</b>
                </button>
            </div>
        </form>
     </div>
     <br>
 
     <div class="justify-content-center align-itens-center row">
        @component(
            'components.tablelistTeacher', [
                "header" => ['Nome', 'Eventos'],
                "data" => $teachers
            ]
        )
        @endcomponent
    </div>
     
    <div class="modal fade" tabindex="-1" role="dialog" id="modalInfo">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informações do professor</h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="cancel" class="btn btn-success" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
     </div>
@endsection

@section('script')


    <script type="text/javascript">

        function loadSubjects() {
            $.getJSON('/api/subjects/load', function (subjects) {
                for(let i = 0; i < subjects.length; i++) {
                    item = '<option value="'+subjects[i].id+'">'+subjects[i].name+'</option>';
                    $('#subject').append(item);
                }
            });
        }

        $(function() {
            loadSubjects();
        })

        function view(id) { 
            $('#modalInfo').modal().find('.modal-body').html("");

            $.getJSON('/api/teachers/'+id, function(data) {
                $('#modalInfo').modal().find('.modal-body').append("<p>ID: <b>"+ data.id +"</b></p><p>E-mail: <b>"+ data.email +"</b></p>");
                $('#modalInfo').modal().find('.modal-title').text(data.name);

                $('#modalInfo').modal('show');
            });
        }

    </script>

@endsection