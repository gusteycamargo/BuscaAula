@extends('templates.main', ['titulo' => "Perfil", 'tag' => "PERFIL"])

@section('conteudo')
 
<div class="justify-content-center align-itens-center row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header bg-dark" style="color: #fff"><b>{{ $student['name'] }}</b></div>
            <div class="card-body">
                <form method="POST" action="{{ route('update') }}">
                    @csrf
                    {{ method_field('put') }}
                    <!-- NOME -->
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $student['name'] }}" required autocomplete="name" autofocus>
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
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $student['email'] }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- BOTÃO - SUBMIT -->
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-dark">
                                {{ __('Editar') }}
                            </button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection