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
                    <td>{{ $item['email'] }}</td>
                    <td>
                        <a nohref style="cursor: pointer" onclick="solicitation('{{ $student_id }}', '{{ $item['id'] }}')"><img src="{{ asset('img/icons/add.png') }}"></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

