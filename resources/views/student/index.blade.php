@extends('templates.main', ['titulo' => "Professores", 'tag' => "PROFESSOR"])

@section('conteudo')
 
     <div>
        <form class='row justify-content-center' method="POST" action="{{ route('filter') }}">
            @csrf
            <div class='col-sm-2'>
                <label for="hour_initial">De</label>
                <input id="hour_initial" type="time" class="form-control" name="hour_initial" autocomplete="hour_initial" autofocus>
            </div>
            <div class='col-sm-2'>
                <label for="hour_final">Até</label>
                <input id="hour_final" type="time" class="form-control" name="hour_final" autocomplete="hour_final" autofocus>
            </div>
            <div class='col-sm-2'>
                <label for="subject">Matéria</label>
                <select name="subject" id="subject" class="form-control">
                    <option></option>
                </select>
            </div>
            <div class='col-sm-2'>
                <label style="visibility: hidden">Filtrar</label>
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
                "header" => ['Nome', 'E-mail', 'Solicitar matrícula'],
                "data" => $teachers,
                "student_id" => Auth::user()->id
            ]
        )
        @endcomponent
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

        function solicitation(student, teacher) { 
            solicitation = {
                student_id: student,
                teacher_id: teacher
            };

            $.ajax({
                type: "POST",
                url: "/api/solicitations",
                context: this,
                data: solicitation,
                success: function (data) {
                    alert('SOLICITAÇÂO ENVIADA')
                },
                error: function(error) {
                    alert(error.responseText);
                    console.log(error);
                }
            })
        }

    </script>

@endsection