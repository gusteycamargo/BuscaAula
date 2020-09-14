@extends('templates.default', ['titulo' => "Solicitações", 'tag' => "SOL"])

@section('conteudo')
 
     <br>
     
     <div class="justify-content-center align-itens-center row">
        @if(Auth::user()->subject_id == null)
            <p>Acesse a página meu perfil para adicionar uma matéria e os alunos encontrarem você mais facilmente!</p>
        @endif
        @component(
            'components.tablelistSolicitations', [
                "header" => ['Nome', 'E-mail', 'Eventos'],
                "data" => $solicitations
            ]
        )
        @endcomponent
    </div>

     <div class="modal" tabindex="-1" role="dialog" id="modalAddToClass">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formAddToClass">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar a turma</h5>
                    </div>
                    <div class="modal-body">
                        <div class='col-sm-12' style="margin-top: 10px">
                            <label>Turmas disponíveis</label>
                            <select name="classes" id="classes" class="form-control" required>
                                
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
        let idOfStudentSelected = '';
        let idOfSolicitation = '';

        function loadSelects(id) {
            $.getJSON('/api/classes/load/'+id, function (data) {
                console.log(data);
                for(i = 0; i < data.length; i++) {
                    item = '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                    $('#classes').append(item);
                }
            });
        }

        $(function() {
            let userId = {!! Auth::user()->id !!}
            loadSelects(userId);
        })

        
        function addToClass(idStudent, idSolicitation) {
            idOfStudentSelected = idStudent;
            idOfSolicitation = idSolicitation;

            $('#modalAddToClass').modal().find('.modal-title').text("Adicionar a turma");
            $('#classes').val('');
            $('#modalAddToClass').modal('show');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })

        $("#formAddToClass").submit( function(event) {
            event.preventDefault();
            insert();
            $('#modalAddToClass').modal('hide')
        });

        function insert() {
            registration = {
                classroom_id: $("#classes").val(),
                student_id: idOfStudentSelected,
                solicitation_id: idOfSolicitation
            };
            console.log(registration);
            $.post("/api/registration", registration, function(data) {
                $("#"+idOfSolicitation+"solc").remove();
                
                alert('Aluno cadastrado na turma!')
            });
        }

        function deleteSolicitation(id) {
            $.ajax({
                type: "DELETE",
                url: "/api/solicitations/"+id,
                context: this,
                success: function (data) {
                    $("#"+id+"solc").remove();
                
                    alert('Solicitação recusada!')
                },
                error: function(error) {
                    alert('ERRO AO EXCLUIR SOLICITAÇÂO');
                }
            })
        }

    </script>

@endsection