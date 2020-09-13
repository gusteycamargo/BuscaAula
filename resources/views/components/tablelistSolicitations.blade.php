<div class="table-responsive col-sm-8" style="overflow-x: visible; overflow-y: visible;">
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
                <tr id="{{ $item['id'] }}solc" style="text-align: center">
                    <td style="display: none">{{ $item['id'] }}</td>
                    <td>{{ $item['student']['name'] }}</td>
                    <td>{{ $item['student']['email'] }}</td>
                    <td>
                        <a nohref style="cursor: pointer" onclick="addToClass('{{ $item['student']['id'] }}', '{{ $item['id'] }}')"><img src="{{ asset('img/icons/add.png') }}"></a>
                        <a nohref style="cursor: pointer" onclick="deleteSolicitation('{{ $item['id'] }}')"><img style='width: 22px; height: 22px' src="{{ asset('img/icons/close.png') }}"></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


