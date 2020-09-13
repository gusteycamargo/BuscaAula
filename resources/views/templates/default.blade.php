<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Busca-aulas</title>
        <link rel="icon" href="{{ asset('img/ge_icon.ico') }}">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style>
            body {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            footer {
                padding: 50px;
                padding-top: 30px;
            }
            .container-fluid {
                padding: 0;
                margin: 0;
            }
            .navbar { margin-bottom: 30px; }
            .nav-link { color: white; }

            .loading {
                position: fixed;
                z-index: 999;
                overflow: show;
                margin: auto;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                width: 50px;
                height: 50px;
            }
        </style>
    </head>

    <body role="document" class="container-fluid">
        <nav class="navbar navbar-expand-sm navbar-dark bg-info">
            <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                <ul class="navbar-nav">
                    @if($tag=="CURSO")
                        <img width="36px" height="36px" src="{{ asset('img/curso_ico.png') }}">
                    @elseif($tag=="ALUNO")
                        <img width="36px" height="36px" src="{{ asset('img/aluno_ico.png') }}">
                    @elseif($tag=="PERFIL")
                        <img width="36px" height="36px" src="{{ asset('img/admin_ico.png') }}">
                    @elseif($tag=="AUT")
                        <img width="36px" height="36px" src="{{ asset('img/login_ico.png') }}">
                    @elseif($tag=="DISCIPLINA")
                        <img width="36px" height="36px" src="{{ asset('img/disciplina_ico.png') }}">
                    @elseif($tag=="PROFESSOR")
                        <img width="36px" height="36px" src="{{ asset('img/professor_ico.png') }}">
                    @elseif($tag=="HOME")
                        <img width="36px" height="36px" src="{{ asset('img/home_ico.svg') }}">
                    @elseif($tag=="MATRICULA")
                        <img width="36px" height="36px" src="{{ asset('img/conceito_ico.png') }}">
                    @elseif($tag=="NEGADO")
                        <img width="36px" height="36px" src="{{ asset('img/negado.png') }}">
                    @endif
                    &nbsp;&nbsp;&nbsp; <a class="navbar-brand mx-auto"><b>{{ $titulo }}</b></a>
                </ul>
            </div>
            <div class="mx-auto order-0">
                <a class="navbar-brand mx-auto"><b>Busca-aulas</b></a>
            </div>

            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" style="color: #fff" href="{{ route('login-teacher') }}"><b>| {{ __('Login') }} |</b></a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" style="color: #fff" href="{{ route('register-teacher') }}"><b>| {{ __('Registro') }} |</b></a>
                            </li>
                        @endif
                    @elseif(Auth::guard('teacher')->check())
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" style="color: #fff" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <b>{{ Auth::user()->name }}</b><span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item">
                                    E-mail: {{ Auth::user()->email }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('profile-teacher') }}">
                                    <u>Ver meu perfil</u>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout-teacher') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <b>Sair</b>
                                </a>
                                <form id="logout-form" action="{{ route('logout-teacher') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                    <!-- <li class="active">
                        <a class="nav-link" href="{{ url('/') }}"><b>| Home |</b></a>
                    </li> -->
                </ul>
            </div>
        </nav>

        @yield('conteudo')

    </body>
    <hr>
    <footer>
        <b>&copy;2020
            &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
            Gustavo Galdino de Camargo
        </b>
    </footer>

    <script src="{{asset('js/app.js')}}" type="text/javascript"></script>

    @yield('script')

</html>
