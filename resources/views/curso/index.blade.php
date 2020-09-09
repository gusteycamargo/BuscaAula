@extends('templates.main', ['titulo' => "Curso", 'tag' => "CURSO"])

@section('conteudo')
 
     <div class='row'>
         <div class='col-sm-12'>
            <button class="btn btn-primary btn-block" onclick="criar()">
                <b>Cadastrar Novo Curso</b>
            </button>
         </div>
     </div>
     <br>
 
     @component(
         'components.tablelist', [
             "header" => ['Nome', 'Eventos'],
             "data" => $cursos
         ]
     )
     @endcomponent

     <div class="modal" tabindex="-1" role="dialog" id="modalCurso">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formCursos">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Curso</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control">
                        <div class='col-sm-12'>
                            <label><b>Nome</b></label>
                            <input type="text" class="form-control" name="nome" id="nome" required>
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
                    <h5 class="modal-title">Informações do Curso</h5>
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
        function criar() {
            $('#modalCurso').modal().find('.modal-title').text("Novo Curso");
            $('#nome').val('');
            $('#modalCurso').modal('show');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })

        $("#formCursos").submit( function(event) {
            event.preventDefault();
            if($("#id").val() != '') {
                update( $("#id").val() );
            }
            else {
                insert();
            }
            $('#modalCurso').modal('hide')
        })

        function insert() {
            cursos = {
                nome: $("#nome").val(),
            };
            console.log(cursos);
            $.post("/api/cursos", cursos, function(data) {
                novoCurso = JSON.parse(data);
                linha = getLin(novoCurso);
                $('#tabela>tbody').append(linha);
            });
        }

        function update(id) {
            cursos = {
                nome: $("#nome").val(),
            };

            $.ajax({
                type: "PUT",
                url: "/api/cursos/"+id,
                context: this,
                data: cursos,
                success: function (data) {
                    linhas = $("#tabela>tbody>tr");
                    e = linhas.filter( function(i, e) {
                        const dataParse = (JSON.parse(data));
                        return e.cells[0].textContent == dataParse.id;
                    } );
                    //console.log(e[0]);

                    if(e) {
                        e[0].cells[1].textContent = cursos.nome;
                    }
                },
                error: function(error) {
                    alert('ERRO - UPDATE');
                    console.log(error);
                }
            })
        }

        function getLin(curso) {
            var linha = 
            "<tr style='text-align: center'>"+
                "<td style='display: none'>"+ curso.id +"</td>"+
                "<td>"+ curso.nome +"</td>"+
                "<td>"+
                    "<a nohref style='cursor: pointer' onclick='visualizar("+curso.id+")'><img src='{{ asset('img/icons/info.svg') }}'></a>"+
                    "<a nohref style='cursor: pointer' onclick='editar("+curso.id+")'><img src='{{ asset('img/icons/edit.svg') }}'></a>"+
                "</td>"+
            "</tr>";

            return linha;
        }

        function visualizar(id) { 
            $('#modalInfo').modal().find('.modal-body').html("");

            $.getJSON('/api/cursos/'+id, function(data) {
                $('#modalInfo').modal().find('.modal-body').append("<p>ID: <b>"+ data.id +"</b></p>");
                $('#modalInfo').modal().find('.modal-title').text(data.nome);

                $('#modalInfo').modal('show');
            });
        }

        function editar(id) { 
            $('#modalCurso').modal().find('.modal-title').text("Alterar Curso");

            $.getJSON('/api/cursos/'+id, function(data) {
                $('#id').val(data.id);
                $('#nome').val(data.nome);
                $('#modalCurso').modal('show');
            });
        }

    </script>

@endsection