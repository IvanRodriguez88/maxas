<p><b>Tipo de banco: </b> {{$account->bankSeparation->name ?? ""}}</p>
<p><b>Empresa: </b> {{$account->company[0]->name}}</p>
<p><b>Saldo: </b> ${{number_format($account->balance, 2, '.', ',')}}</p>
<p><b>Moneda: </b> {{$account->currencyType->name}}</p>