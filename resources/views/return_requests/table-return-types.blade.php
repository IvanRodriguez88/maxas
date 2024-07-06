<table id="return_request_return_types-table" class="table">
    <thead>
        <th>Beneficiario</th>
        <th>Banco</th>
        <th>F. de retorno</th>
        <th>Clabe o cuenta</th>
        <th>Monto</th>
        <th>Referencia</th>
    </thead>
    <tbody>
        @foreach ($rows as $row)
            <tr>
                <td>{{$row->beneficiary_name}}</td>
                <td>{{$row->bank->name}}</td>
                <td>{{$row->returnType->name}}</td>
                <td>{{$row->account_number}}</td>
                <td>{{$row->amount}}</td>
                <td>{{$row->reference}}</td>
            </tr>
        @endforeach
    </tbody>
</table>