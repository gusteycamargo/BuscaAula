@extends('templates.main', ['titulo' => "Matrículas", 'tag' => "MATRICULA"])

@section('conteudo')
 
     <div class='row'>
         <div class='col-sm-2'>
            <a class="btn btn-secondary btn-block bg-dark" href="{{ route('alunos.index') }}">
                <b>Voltar</b>
            </a>
         </div>
        <div class='col-sm-10'>
            <div class="alert alert-dark d-flex justify-content-between" role="alert">
                <div>
                    <img width="36px" height="36px" src="{{ asset('img/curso_ico.png') }}">
                    <a class="navbar-brand mx-auto">
                        <p>{{$aluno['curso']['nome']}}</p>
                    </a>
                </div>
                <div>
                    <img width="36px" height="36px" src="{{ asset('img/aluno_ico.png') }}">
                    <a class="navbar-brand mx-auto">
                        <p>{{$aluno['nome']}}</p>
                    </a>
                </div>
            </div>
        </div>
     </div>
     <div class='row'>
       <div class='col-sm-12'>
           <div class="alert alert-primary d-flex justify-content-center">
               <div class="d-flex justify-content-center">
                    <img width="36px" height="36px" src="{{ asset('img/conceito_ico.png') }}">
                    <a class="navbar-brand mx-auto">
                        <b>Matrículas do aluno</b>
                    </a>
               </div>
           </div>
       </div>
    </div>


    <div class="table-responsive" style="overflow-x: visible; overflow-y: visible;">
        <table class='table table-striped' id="tabela">
            <tbody id="tbod">
                
            </tbody>
        </table>
    </div>

    <div class='row'>
        <div class='col-sm-12'>
           <button class="btn btn-primary btn-block" onclick="confirm()">
               <b>Confirmar Matrículas</b>
           </button>
        </div>
    </div>

     <br>

@endsection

@section('script')


    <script type="text/javascript">
        function loadDisciplinasDoCurso(id) {
            let a = {!! json_encode($aluno) !!}
            console.log(a.disciplina);
            $.getJSON('/api/cursos/'+id, function (data) {
                for(i = 0; i < data.disciplina.length; i++) {
                    let checked = '';
                    
                    if(a.disciplina.some(disc => disc.id === data.disciplina[i].id)) {
                        console.log('aaaa');
                        checked = 'checked';
                    }
                    item = "<tr>"+
                        "<td>"+
                            "<div class='custom-control custom-checkbox'>"+
                                "<input type='checkbox' "+ checked +" name='disciplinas[]' class='custom-control-input' id='customCheck"+i+"' value='"+data.disciplina[i].id+"'>"+
                                "<label class='custom-control-label' for='customCheck"+i+"'>"+data.disciplina[i].nome+"</label>"+
                            "</div>"+   
                        "</td>"+
                    "</tr>"
                    $('#tbod').append(item);
                }
            })
        }

        $(function() {
            let a = {!! json_encode($aluno) !!}
            loadDisciplinasDoCurso(a.curso.id);
        })

        function confirm() {
            let a = $('input[name ="disciplinas[]"]') 
            const array = [];
            for (const b of a) {
                if(b.checked) {
                    array.push(b.value);
                }
            }

            if(array.length > 0) {
                insert(array);
            }
            else {
                alert('Selecione pelo menos uma opção!')
            }
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })

        function insert(array) {
            let aluno = {!! json_encode($aluno) !!};

            for (const idsD of array) {
                matricula = {
                    aluno: aluno.id,
                    disciplina: idsD,
                };
                $.post("/api/matriculas", matricula, function(data) {
                    console.log(data);
                    
                });
            }
            alert('Matrículas realizadas')
        }

        function returnOptionsDisciplina(disciplina) {
            let options = '';
            if(typeof disciplina != 'undefined' && disciplina.length > 0) {
                for (const a of disciplina) {
                    options = options + " "+ "<option>"+a.nome+"</option>"
                }
            }
            return options
        }

    </script>

@endsection