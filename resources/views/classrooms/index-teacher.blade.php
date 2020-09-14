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
                        <div class='col-sm-12' style="margin-top: 14px">
                            <label><b id="labelStudents">Alunos matrículados</b></label>
                            <div id="students" class="column">

                            </div>
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
            $('#labelStudents').text('');
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
            $('#labelStudents').text('Alunos matrículados');
            $.getJSON('/api/classes/'+id, function(data) {
                console.log(data);
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#students').empty();
                let line = ''
                for (const stud of data.student) {
                    line = line + '<div>'
                    line = line + '<input type="checkbox" name="students[]" value="'+stud.id+'"> <label>'+stud.name+'</label>'
                    line = line + '</div>'
                }
                
                $('#students').append(line)
                $('#modalClass').modal('show');
            });
        }

        function update(id) {
            var val = [];
            $(':checkbox:checked').each(function(i){
                val[i] = $(this).val();
            });

            classes = {
                name: $("#name").val(),
                students: val
            };

            $.ajax({
                type: "PUT",
                url: "/api/classes/"+id,
                context: this,
                data: classes,
                success: function (data) {
                    console.log(data);
                    lines = $("#tabela>tbody>tr");
                    const dataParse = (JSON.parse(data));
                    e = lines.filter( function(i, e) {
                        return e.cells[0].textContent == dataParse.id;
                    } );
 
                    if(e) {
                        e[0].cells[1].textContent = dataParse.name;
                        $("#"+dataParse.id+"selectsStudents").empty();

                        let lineselect = '<select class="form-control">';
                        for (let i = 0; i < dataParse.student.length; i++) {
                            lineselect = lineselect + '<option>'+dataParse.student[i].name+'</option>';
                        }

                        lineselect = lineselect + '</select>';
                        $("#"+dataParse.id+"selectsStudents").append(lineselect);
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

        function deleteClassroom(id) {
            $.ajax({
                type: "DELETE",
                url: "/api/classes/"+id,
                context: this,
                success: function (data) {
                    $("#"+id+"line").remove();
                
                    alert('Turma excluída!')
                },
                error: function(error) {
                    alert('ERRO AO EXCLUIR TURMA');
                }
            })
        }

    </script>

@endsection