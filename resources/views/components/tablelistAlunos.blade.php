<div class="table-responsive" style="overflow-x: visible; overflow-y: visible;">
    <table class='table table-striped' id="tabela">
        <thead>
            <tr style="text-align: center">
                @foreach ($header as $item)
                    <th>{{ $item }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach (json_decode($data, true) as $item)
                <tr style="text-align: center">
                    <td style="display: none">{{ $item['id'] }}</td>
                    <td>{{ $item['nome'] }}</td>
                    <td>{{ $item['email'] }}</td>
                    <td>{{ $item['curso']['nome'] }}</td>
                    <td>
                        <select class="form-control">
                            @foreach ($item['disciplina'] as $a)
                                <option>{{$a['nome']}}</option>
                            @endforeach
                        </select>
                    </td>
                    {{-- href="/matricula/{{$item['id'] }}" --}}
                    <td>
                        <a nohref style="cursor: pointer" onclick="editar('{{ $item['id'] }}')"><img src="{{ asset('img/icons/edit.svg') }}"></a>
                        <a nohref style="cursor: pointer" href="{{ route('matriculas.show', $item['id']) }}"><img src="{{ asset('img/icons/config.svg') }}"></a>
                    </td> 
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

