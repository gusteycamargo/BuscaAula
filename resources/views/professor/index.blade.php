@extends('templates.main', ['titulo' => "Professor", 'tag' => "PROFESSOR"])

@section('conteudo')
 
     <div class='row'>
         <div class='col-sm-12'>
            <button class="btn btn-primary btn-block" onclick="criar()">
                <b>Cadastrar Novo Professor</b>
            </button>
         </div>
     </div>
     <br>
 
     @component(
         'components.tablelistProfessor', [
             "header" => ['Nome', 'E-mail', 'Eventos'],
             "data" => $professores
         ]
     )
     @endcomponent

     <div class="modal" tabindex="-1" role="dialog" id="modalProfessor">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formProfessor">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Professor</h5>
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
        function criar() {
            $('#modalProfessor').modal().find('.modal-title').text("Novo Professor");
            $('#nome').val('');
            $('#email').val('');
            $('#modalProfessor').modal('show');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })

        $("#formProfessor").submit( function(event) {
            event.preventDefault();
            if($("#id").val() != '') {
                update( $("#id").val() );
            }
            else {
                insert();
            }
            $('#modalProfessor').modal('hide')
        })

        function insert() {
            professores = {
                nome: $("#nome").val(),
                email: $("#email").val(),
            };
            $.post("/api/professores", professores, function(data) {
                novoProfessor = JSON.parse(data);
                linha = getLin(novoProfessor);
                $('#tabela>tbody').append(linha);
            });
        }

        function update(id) {
            professores = {
                nome: $("#nome").val(),
                email: $("#email").val(),
            };

            $.ajax({
                type: "PUT",
                url: "/api/professores/"+id,
                context: this,
                data: professores,
                success: function (data) {
                    linhas = $("#tabela>tbody>tr");
                    e = linhas.filter( function(i, e) {
                        const dataParse = (JSON.parse(data));
                        return e.cells[0].textContent == dataParse.id;
                    } );
                    //console.log(e[0]);

                    if(e) {
                        e[0].cells[1].textContent = professores.nome;
                        e[0].cells[2].textContent = professores.email;
                    }
                },
                error: function(error) {
                    alert('ERRO - UPDATE');
                    console.log(error);
                }
            })
        }

        function getLin(professor) {
            var linha = 
            "<tr style='text-align: center'>"+
                "<td style='display: none'>"+ professor.id +"</td>"+
                "<td>"+ professor.nome +"</td>"+
                "<td>"+ professor.email +"</td>"+
                "<td>"+
                    "<a nohref style='cursor: pointer' onclick='visualizar("+professor.id+")'><img src='{{ asset('img/icons/info.svg') }}'></a>"+
                    "<a nohref style='cursor: pointer' onclick='editar("+professor.id+")'><img src='{{ asset('img/icons/edit.svg') }}'></a>"+
                "</td>"+
            "</tr>";

            return linha;
        }

        function visualizar(id) { 
            $('#modalInfo').modal().find('.modal-body').html("");

            $.getJSON('/api/professores/'+id, function(data) {
                $('#modalInfo').modal().find('.modal-body').append("<p>ID: <b>"+ data.id +"</b></p>");
                $('#modalInfo').modal().find('.modal-title').text(data.nome);
                $('#modalInfo').modal().find('.modal-body').append("<p>E-mail: <b>"+ data.email +"</b></p>");

                $('#modalInfo').modal('show');
            });
        }

        function editar(id) { 
            $('#modalProfessor').modal().find('.modal-title').text("Alterar Professor");

            $.getJSON('/api/professores/'+id, function(data) {
                $('#id').val(data.id);
                $('#nome').val(data.nome);
                $('#email').val(data.email);
                $('#modalProfessor').modal('show');
            });
        }

    </script>

@endsection