@extends('templates.main', ['titulo' => "Disciplina", 'tag' => "DISCIPLINA"])

@section('conteudo')
 
     <div class='row'>
         <div class='col-sm-12'>
            <button class="btn btn-primary btn-block" onclick="criar()">
                <b>Cadastrar Nova Disciplina</b>
            </button>
         </div>
     </div>
     <br>
 
     @component(
         'components.tablelistDisciplina', [
             "header" => ['Nome', 'Curso', 'Professor', 'Eventos'],
             "data" => $disciplinas
         ]
     )
     @endcomponent

     <div class="modal" tabindex="-1" role="dialog" id="modalDisciplina">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formDisciplinas">
                    <div class="modal-header">
                        <h5 class="modal-title">Nova Disciplina</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control">
                        <div class='col-sm-12'>
                            <label><b>Nome</b></label>
                            <input type="text" class="form-control" name="nome" id="nome" required>
                        </div>
                        <div class='col-sm-12' style="margin-top: 10px">
                            <label>Professor</label>
                            <select name="professor" id="professor" class="form-control" required>
                                
                            </select>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="modalInfo">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informações da disciplina</h5>
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
        function loadSelects() {
            $.getJSON('/api/cursos/load', function (data) {
                for(i = 0; i < data.length; i++) {
                    item = '<option value="'+data[i].id+'">'+data[i].nome+'</option>';
                    $('#curso').append(item);
                }
            });

            $.getJSON('/api/professores/load', function (data) {
                for(i = 0; i < data.length; i++) {
                    item = '<option value="'+data[i].id+'">'+data[i].nome+'</option>';
                    $('#professor').append(item);
                }
            });
        }

        $(function() {
            loadSelects();
        })

        
        function criar() {
            $('#modalDisciplina').modal().find('.modal-title').text("Nova Disciplina");
            $('#nome').val('');
            $('#curso').val('');
            $('#professor').val('');
            $('#modalDisciplina').modal('show');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })

        $("#formDisciplinas").submit( function(event) {
            event.preventDefault();
            if($("#id").val() != '') {
                update( $("#id").val() );
            }
            else {
                insert();
            }
            $('#modalDisciplina').modal('hide')
        });

        function insert() {
            disciplinas = {
                nome: $("#nome").val(),
                curso: $("#curso").val(),
                professor: $("#professor").val(),
            };
            $.post("/api/disciplinas", disciplinas, function(data) {
                novaDisciplina = JSON.parse(data);
                linha = getLin(novaDisciplina);
                $('#tabela>tbody').append(linha);
            });
        }

        function update(id) {
            disciplinas = {
                nome: $("#nome").val(),
                curso: $("#curso").val(),
                professor: $("#professor").val(),
            };

            $.ajax({
                type: "PUT",
                url: "/api/disciplinas/"+id,
                context: this,
                data: disciplinas,
                success: function (data) {
                    linhas = $("#tabela>tbody>tr");
                    const dataParse = (JSON.parse(data));
                    e = linhas.filter( function(i, e) {
                        return e.cells[0].textContent == dataParse.id;
                    } );
                    console.log(e);

                    if(e) {
                        e[0].cells[1].textContent = dataParse.nome;
                        e[0].cells[2].textContent = dataParse.curso.nome;
                        e[0].cells[3].textContent = dataParse.professor.nome;
                    }
                },
                error: function(error) {
                    alert('ERRO - UPDATE');
                    console.log(error);
                }
            })
        }

        function getLin(disciplina) {
            var linha = 
            "<tr style='text-align: center'>"+
                "<td style='display: none'>"+ disciplina.id +"</td>"+
                "<td>"+ disciplina.nome +"</td>"+
                "<td>"+ disciplina.curso.nome +"</td>"+
                "<td>"+ disciplina.professor.nome +"</td>"+
                "<td>"+
                    "<a nohref style='cursor: pointer' onclick='editar("+disciplina.id+")'><img src='{{ asset('img/icons/edit.svg') }}'></a>"+
                "</td>"+
            "</tr>";

            return linha;
        }

        function editar(id) { 
            $('#modalDisciplina').modal().find('.modal-title').text("Alterar Turma");

            $.getJSON('/api/disciplinas/'+id, function(data) {
                $('#id').val(data.id);
                $('#nome').val(data.nome);
                $('#curso').val(data.curso);
                $('#professor').val(data.professor);
                $('#modalDisciplina').modal('show');
            });
        }

    </script>

@endsection