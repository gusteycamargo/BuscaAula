
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
                @foreach ($data as $item)
                    <tr style="text-align: center">
                        <td style="display: none">{{ $item['id'] }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>
                            <a nohref style="cursor: pointer" onclick="view('{{ $item['id'] }}')"><img src="{{ asset('img/icons/info.svg') }}"></a>
                            <a nohref style="cursor: pointer" onclick="edit('{{ $item['id'] }}')"><img src="{{ asset('img/icons/edit.svg') }}"></a>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

