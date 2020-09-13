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
                <tr style="text-align: center">
                    <td style="display: none">{{ $item['id'] }}</td>
                    <td>{{ $item['classroom']['name'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


