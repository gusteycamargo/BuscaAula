@extends('templates.main', ['titulo' => "", 'tag' => ""])

@section('conteudo')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-dark d-flex justify-content-between" role="alert">
                <a class="navbar-brand mx-auto">
                    <p>Você quer estudar ou dar aulas? É só escolhar uma opção abaixo</p>
                </a>
            </div>
            <div class="card-body">
                <div class='row d-flex justify-content-center'>
                    <div class="col-sm-3" style="text-align: center">
                        <a href="/login">
                            <img style="width: 128px; height: 128px" src="{{ asset('img/professor_ico.png') }}">
                        </a>
                        <h3>
                            <b>Estudar</b>
                        </h3>
                    </div>
                    <div class="col-sm-3" style="text-align: center">
                        <a href="/teacher/login">
                            <img style="width: 128px; height: 128px" src="{{ asset('img/admin_ico.png') }}">
                        </a>
                        <h3>
                            <b>Dar aulas</b>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
