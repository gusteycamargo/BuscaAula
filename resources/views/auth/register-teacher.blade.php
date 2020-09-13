@extends('templates.default', ['titulo' => "Registro", 'tag' => "REG"])

@section('conteudo')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark" style="color: #fff"><b>{{ __('Registro - Professor ') }}</b></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register-teacher') }}">
                        @csrf
                        <!-- NOME -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- E-MAIL -->
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail (Login)') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- MATÉRIAS -->
                        <div class="form-group row">
                            <label for="subject" class="col-md-4 col-form-label text-md-right">{{ __('Matéria') }}</label>
                            <div class="col-md-6">
                                <select name="subject" id="subject" class="form-control" required>
                                    <option></option>
                                </select>
                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- INICIAL -->
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Horário disponível') }}</label>
                                <div class="col col-md-3">
                                    <input id="hour_initial" placeholder="De" type="time" class="form-control @error('hour_initial') is-invalid @enderror" name="hour_initial" required autocomplete="hour_initial">
                                    @error('hour_initial')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col col-md-3">
                                    <input id="hour_final" placeholder="Até" type="time" class="form-control @error('hour_final') is-invalid @enderror" name="hour_final" required autocomplete="hour_final">
                                    @error('hour_final')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- SENHA -->
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- CONFIRMAÇÃO SENHA -->
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmação Senha') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <!-- BOTÃO - SUBMIT -->
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-dark">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')


    <script type="text/javascript">
        function loadSubjects() {
            $.getJSON('/api/subjects/load', function (subjects) {
                for(let i = 0; i < subjects.length; i++) {
                    item = '<option value="'+subjects[i].id+'">'+subjects[i].name+'</option>';
                    $('#subject').append(item);
                }
            });
        }

        $(function() {
            loadSubjects();
        })

    </script>

@endsection