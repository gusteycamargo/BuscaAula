@extends('templates.main', ['titulo' => "Matérias", 'tag' => "CURSO"])

@section('conteudo')
 
<div class="justify-content-center align-itens-center row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header bg-dark" style="color: #fff"><b>{{ $student['name'] }}</b></div>
            <div class="card-body">
                <form method="PUT" action="{{ route('register-teacher') }}">
                    @csrf
                    <!-- NOME -->
                    <div class="form-group">
                        <p>{{ $student['email'] }}</p>
                        
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection