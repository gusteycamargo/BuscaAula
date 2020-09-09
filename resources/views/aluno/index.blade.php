@extends('templates.main', ['titulo' => "Aluno", 'tag' => "ALUNO"])

@section('conteudo')
 
     <div class='row'>
         <div class='col-sm-12'>
            <button class="btn btn-primary btn-block" onclick="criar()">
                <b>Cadastrar Novo Aluno</b>
            </button>
         </div>
     </div>
     <br>
 
     @component(
         'components.tablelistAlunos', [
             "header" => ['Nome', 'E-mail', 'Curso', 'Disciplinas', 'Eventos'],
             "data" => $alunos
         ]
     )
     @endcomponent

     <div class="modal" tabindex="-1" role="dialog" id="modalAluno">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formAlunos">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Aluno</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control">
                        <div class='col-sm-12'>
                            <label><b>Nome</b></label>
                            <input type="text" class="form-control" name="nome" id="nome" required>
                        </div>
                        <div class='col-sm-12' style="margin-top: 10px">
                            <label>E-mail</label>
                            <input type="text" class="form-control" name="email" id="email" required>
                        </div>
                        <div class='col-sm-12' style="margin-top: 10px">
                            <label>Curso</label>
                            <select name="curso" id="curso" class="form-control" required>
                                
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')


    <script type="text/javascript">
        function loadCursos() {
            $.getJSON('/api/cursos/load', function (data) {
                for(i = 0; i < data.length; i++) {
                    item = '<option value="'+data[i].id+'">'+data[i].nome+'</option>';
                    $('#curso').append(item);
                }
            })
        }

        $(function() {
            loadCursos();
        })

        function criar() {
            $('#modalAluno').modal().find('.modal-title').text("Novo Aluno");
            $('#nome').val('');
            $('#email').val('');
            $('#curso').val('');
            $('#modalAluno').modal('show');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })

        $("#formAlunos").submit( function(event) {
            event.preventDefault();
            if($("#id").val() != '') {
                update( $("#id").val() );
            }
            else {
                insert();
            }
            $('#modalAluno').modal('hide')
        })

        function insert() {
            alunos = {
                nome: $("#nome").val(),
                email: $("#email").val(),
                curso: $("#curso").val(),
            };
            $.post("/api/alunos", alunos, function(data) {
                novoAluno = JSON.parse(data);
                console.log(novoAluno);
                linha = getLin(novoAluno);
                $('#tabela>tbody').append(linha);
            });
        }

        function update(id) {
            alunos = {
                nome: $("#nome").val(),
                email: $("#email").val(),
                curso: $("#curso").val(),
            };

            $.ajax({
                type: "PUT",
                url: "/api/alunos/"+id,
                context: this,
                data: alunos,
                success: function (data) {
                    linhas = $("#tabela>tbody>tr");
                    const dataParse = (JSON.parse(data));
                    e = linhas.filter( function(i, e) {
                        return e.cells[0].textContent == dataParse.id;
                    } );
                    console.log(e[0]);

                    if(e) {
                        e[0].cells[1].textContent = dataParse.nome;
                        e[0].cells[2].textContent = dataParse.email;
                        e[0].cells[3].textContent = dataParse.curso.nome;
                    }
                },
                error: function(error) {
                    alert('ERRO - UPDATE');
                    console.log(error);
                }
            })
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

        function getLin(aluno) {
            let options = returnOptionsDisciplina(aluno.disciplina);
            console.log(aluno);
            var linha = 
            "<tr style='text-align: center'>"+
                "<td style='display: none'>"+ aluno.id +"</td>"+
                "<td>"+ aluno.nome +"</td>"+
                "<td>"+ aluno.email +"</td>"+
                "<td>"+aluno.curso.nome+"</td>"+
                "<td>"+
                    "<select class='form-control'>"+
                        options+
                    "</select>"+
                "</td>"+
                "<td>"+
                    "<a nohref style='cursor: pointer' onclick='editar("+aluno.id+")'><img src='{{ asset('img/icons/edit.svg') }}'></a>"+
                    "<a nohref style='cursor: pointer' href='/matriculas/"+aluno.id+"'><img src='{{ asset('img/icons/config.svg') }}'></a>"+
                "</td>"+
            "</tr>";

            return linha;
        }

        function editar(id) { 
            $('#modalAluno').modal().find('.modal-title').text("Alterar Aluno");

            $.getJSON('/api/alunos/'+id, function(data) {
                $('#id').val(data.id);
                $('#nome').val(data.nome);
                $('#email').val(data.email);
                $('#curso').val(data.curso);
                $('#modalAluno').modal('show');
            });
        }

    </script>

@endsection