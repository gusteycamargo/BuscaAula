@extends('templates.default', ['titulo' => "Turmas", 'tag' => "DISCIPLINA"])

@section('conteudo')
 
    <div class='row justify-content-center'>
         <div class='col-sm-8'>
            <button class="btn btn-primary btn-block" onclick="create('{{ Auth::user()->id }}')">
                <b>Cadastrar Nova Turma</b>
            </button>
         </div>
     </div>
     <br>
 
     <div class="justify-content-center align-itens-center row">
        @component(
            'components.tablelistClasses', [
                "header" => ['Nome', 'Integrantes', 'Eventos'],
                "data" => $classes
            ]
        )
        @endcomponent
    </div>

     <div class="modal" tabindex="-1" role="dialog" id="modalClass">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" id="formClass">
                    <div class="modal-header">
                        <h5 class="modal-title">Nova turma</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" class="form-control">
                        <div class='col-sm-12'>
                            <label><b>Nome</b></label>
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
@endsection

@section('script')


    <script type="text/javascript">
        let teacher_id = '';

        function create(id) {
            teacher_id = id;
            $('#modalClass').modal().find('.modal-title').text("Nova turma");
            $('#name').val('');
            $('#modalClass').modal('show');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })

        $("#formClass").submit( function(event) {
            event.preventDefault();
            if($("#id").val() != '') {
                update( $("#id").val() );
            }
            else {
                insert();
            }
            $('#modalClass').modal('hide')
        });

        function insert() {
            classes = {
                name: $("#name").val(),
                teacher_id,
            };
            console.log(classes);
            $.ajax({
                type: "POST",
                url: "/api/classes",
                context: this,
                data: classes,
                success: function (data) {
                    newClass = JSON.parse(data);
                    line = getLin(newClass);
                    console.log(line);
                    $('#tabela>tbody').append(line);
                },
                error: function(error) {
                    alert('ERRO - UPDATE');
                    console.log(error);
                }
            })
            // $.post("/api/classes", classes, function(data) {
            //     console.log(data);
            //     newClass = JSON.parse(data);
            //     line = getLin(newClass);
            //     $('#tabela>tbody').append(line);
            // });
        }

        function getLin(classes) {
            var line = 
            "<tr style='text-align: center'>"+
                "<td style='display: none'>"+ classes.id +"</td>"+
                "<td>"+ classes.name +"</td>"+
                "<td>"+
                    "<select class='form-control'>"+
                        "<option></option>"+
                    "</select>"+
                "</td>"+
                "<td>"+
                    "<a nohref style='cursor: pointer' onclick='edit("+classes.id+")'><img src='{{ asset('img/icons/edit.svg') }}'></a>"+
                "</td>"+
            "</tr>";

            return line;
        }

        function edit(id) { 
            $('#modalClass').modal().find('.modal-title').text("Alterar turma");

            $.getJSON('/api/classes/'+id, function(data) {
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#modalClass').modal('show');
            });
        }

        function update(id) {
            classes = {
                name: $("#name").val(),
            };

            $.ajax({
                type: "PUT",
                url: "/api/classes/"+id,
                context: this,
                data: classes,
                success: function (data) {
                    lines = $("#tabela>tbody>tr");
                    const dataParse = (JSON.parse(data));
                    e = lines.filter( function(i, e) {
                        return e.cells[0].textContent == dataParse.id;
                    } );
                    console.log(e);

                    if(e) {
                        e[0].cells[1].textContent = dataParse.name;
                        //e[0].cells[2].textContent = dataParse.curso.nome;
                        //e[0].cells[3].textContent = dataParse.professor.nome;
                    }
                },
                error: function(error) {
                    alert('ERRO - UPDATE');
                    console.log(error);
                }
            })
        }

    </script>

@endsection