@extends('templates.default', ['titulo' => "Matérias", 'tag' => "CURSO"])

@section('conteudo')
 
     <div class='row justify-content-center'>
         <div class='col-sm-8'>
            @if(Auth::user()->subject_id == null)
                <p>Acesse a página meu perfil para adicionar uma matéria e os alunos encontrarem você mais facilmente!</p>
            @endif
            <button class="btn btn-primary btn-block" onclick="criar()">
                <b>Cadastrar Nova Matéria</b>
            </button>
         </div>
     </div>
     <br>
 
     <div class="justify-content-center align-itens-center row">

        @component(
            'components.tablelist', [
                "header" => ['Nome', 'Eventos'],
                "data" => $subjects
            ]
        )
        @endcomponent
    </div>
     <div class="modal" tabindex="-1" role="dialog" id="modalSubject">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formSubject">
                    <div class="modal-header">
                        <h5 class="modal-title">Nova matéria</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control">
                        <div class='col-sm-12'>
                            <label for="name"><b>Nome</b></label>
                            <input type="text" class="form-control" name="name" id="name" required>
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
                    <h5 class="modal-title">Informações da matéria</h5>
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
            $('#modalSubject').modal().find('.modal-title').text("Nova matéria");
            $('#name').val('');
            $('#modalSubject').modal('show');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })

        $("#formSubject").submit( function(event) {
            event.preventDefault();
            if($("#id").val() != '') {
                update( $("#id").val() );
            }
            else {
                insert();
            }
            $('#modalSubject').modal('hide')
        })

        function insert() {
            subject = {
                name: $("#name").val(),
            };
            $.post("/api/subjects", subject, function(data) {
                newSubject = JSON.parse(data);
                line = getLin(newSubject);
                $('#tabela>tbody').append(line);
            });
        }

        function update(id) {
            subjects = {
                name: $("#name").val(),
            };

            $.ajax({
                type: "PUT",
                url: "/api/subjects/"+id,
                context: this,
                data: subjects,
                success: function (data) {
                    linhas = $("#tabela>tbody>tr");
                    e = linhas.filter( function(i, e) {
                        const dataParse = (JSON.parse(data));
                        return e.cells[0].textContent == dataParse.id;
                    } );
                    //console.log(e[0]);

                    if(e) {
                        e[0].cells[1].textContent = subjects.name;
                    }
                },
                error: function(error) {
                    alert('ERRO - UPDATE');
                    console.log(error);
                }
            })
        }

        function getLin(subject) {
            var linha = 
            "<tr style='text-align: center'>"+
                "<td style='display: none'>"+ subject.id +"</td>"+
                "<td>"+ subject.name +"</td>"+
                "<td>"+
                    "<a nohref style='cursor: pointer' onclick='view("+subject.id+")'><img src='{{ asset('img/icons/info.svg') }}'></a>"+
                    "<a nohref style='cursor: pointer' onclick='edit("+subject.id+")'><img src='{{ asset('img/icons/edit.svg') }}'></a>"+
                "</td>"+
            "</tr>";

            return linha;
        }

        function view(id) { 
            $('#modalInfo').modal().find('.modal-body').html("");

            $.getJSON('/api/subjects/'+id, function(data) {
                $('#modalInfo').modal().find('.modal-body').append("<p>ID: <b>"+ data.id +"</b></p>");
                $('#modalInfo').modal().find('.modal-title').text(data.name);

                $('#modalInfo').modal('show');
            });
        }

        function edit(id) { 
            $('#modalSubject').modal().find('.modal-title').text("Alterar matéria");

            $.getJSON('/api/subjects/'+id, function(data) {
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#modalSubject').modal('show');
            });
        }

    </script>

@endsection