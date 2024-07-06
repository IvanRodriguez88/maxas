<!DOCTYPE html>
<html>
<head>
    <title>Ejemplo de Correo</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        td {
            padding-right: 15px;
        }
        th {
            text-align: left;
        }

        table{ 
            border-collapse: collapse;

        }
        .table-two td, th{
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h2>Solicitud de retorno {{$return_request->id}}</h2>
    <p style="text-align: end"><b>Fecha:</b> {{date("d/m/Y", strtotime($return_request->date))}}</p>
    <table>
        <tbody>
            <tr>
                <td><b>Cliente: </b> {{$return_request->client->name}}</td>
                <td><b>Empresa: </b> {{$return_request->company->name}}</td>
            </tr>
            <tr>
                <td><b>Banco: </b> {{$return_request->account->bank->name}}</td>
                <td><b>Cuenta: </b> {{$return_request->account->account_number ?? "N/A"}}</td>
                <td><b>Clabe: </b> {{$return_request->account->clabe ?? "N/A"}}</td>
            </tr>
        </tbody>
    </table>
    <hr>
    <table>
        <tbody class="table-two">
            <tr>
                <th>Base de retorno</th>
                <td>{{$return_request->returnBase->name}} - {{$return_request->returnBase->description ?? ""}}</td>
            </tr>

            <tr>
                <th>Promotor</th>
                <td>{{$return_request->promotor->name ?? "N/A"}}</td>
            </tr>

            <tr>
                <th>Total de la factura</th>
                <td>$ {{number_format($return_request->total_invoice, 2, '.', ',')}}</td>
            </tr>
            <tr>
                <th>Total a retornar</th>
                <td>$ {{number_format($return_request->total_return, 2, '.', ',')}}</td>
            </tr>
        </tbody>
    </table>
   

</body>
</html>
