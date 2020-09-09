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
                    <td>{{ $item['curso']['nome'] }}</td>
                    <td>{{ $item['professor']['nome'] }}</td>
                    <td>
                        <a nohref style="cursor: pointer" onclick="editar('{{ $item['id'] }}')"><img src="{{ asset('img/icons/edit.svg') }}"></a>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


