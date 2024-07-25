<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Ver solicitud de retorno
    </x-slot>



    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/return_requests/return_requests.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        <div class="d-flex justify-content-center">
            <div class="w-75">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Solicitud de retorno #{{$return_request->id}}</h5>
                            <div >
                                <p class="m-0"><b>Fecha solicitado:</b> {{date('d/m/Y H:i:s', strtotime($return_request->date))}}</p>
                                <p class="m-0">
                                    <b>Requiere factura:</b>
                                    @if ($return_request->requires_invoice)
                                        <span class="badge badge-light-success mb-2 me-4">SÍ</span>
                                    @else
                                        <span class="badge badge-light-danger mb-2 me-4">NO</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex gap-3">
                            <div>
                                <p><b>Razón social:</b> {{ $return_request->clientBusiness->business_name }}</p>
                                <p><b>RFC:</b> {{ $return_request->clientBusiness->rfc }}</p>
                                <p><b>Estado</b>: {{ $return_request->clientBusiness->state }}</p>
                                <p><b>Ciudad:</b> {{ $return_request->clientBusiness->city }}</p>
                            </div>
                            <div>
                                <p><b>Código postal:</b> {{ $return_request->clientBusiness->postal_code }}</p>
                                <p><b>Calle y número:</b> {{ $return_request->clientBusiness->street_and_number }}</p>
                                <p><b>Colonia:</b> {{ $return_request->clientBusiness->cologne }}</p>
                                @if ($return_request->clientBusiness->file !== null)
                                    <a id="file" target="_blank" href="{{ route('clients.downloadBusinessFile', $return_request->client_business_id) }}">
                                        <u>Constancia de situación fiscal</u>
                                    </a>
                                @else
                                    <p class="text-secondary">Sin carga de Constancia de situación fiscal</p>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between gap-3">
                            <div class="p-3 w-50" style="border: 1px solid #bdbdbd; border-radius: 5px">
                                <p><b>Empresa:</b> {{$return_request->company->name}}</p>
                                <hr class="m-0 p-0 mb-1">
                                <p><b>Cuenta a depositar:</b> </p>
                                <p><b>Banco:</b> {{$return_request->account->bank->name}}</p>
                                <p><b>CLABE:</b> {{$return_request->account->clabe ?? "N/A"}}</p>
                                <p><b>Número de cuenta:</b> {{$return_request->account->account_number ?? "N/A"}}</p>
                            </div>
                            <div class="p-3 w-50" style="border: 1px solid #bdbdbd; border-radius: 5px">
                                <p><b>Subtotal: </b> $ {{ number_format($return_request->subtotal, 2, '.', ',') }}</p>
                                <p><b>IVA: </b> $ {{ number_format($return_request->iva, 2, '.', ',') }}</p>
                                <p><b>Total de factura:</b> $ {{ number_format($return_request->total_invoice, 2, '.', ',') }}</p>
                                <hr class="m-0 p-0 mb-1">
                                <p class="text-primary"><b>Total a retornar:</b> $ {{ number_format($return_request->total_return, 2, '.', ',') }}</p>
                                <p class="text-success"><b>Total pedido:</b> $ {{ number_format($return_request->getTotalSumReturnTypeAttribute(), 2, '.', ',') }}</p>
                                <p><b>Resto:</b> $ {{ number_format($return_request->total_return - $return_request->getTotalSumReturnTypeAttribute(), 2, '.', ',') }}</p>

                            </div>
                        </div>

                        <hr>
                        <p><b>Conceptos</b></p>
                        <table class="table">
                            <thead>
                                <th>C.</th>
                                <th>Unidad</th>
                                <th>Concepto</th>
                                <th>Descripción</th>
                                <th>P. unitario</th>
                                <th>Importe</th>
                            </thead>
                            <tbody>
                                @foreach ($return_request->returnConcepts as $return_concept)
                                    <tr>
                                        <td>{{$return_concept->amount}}</td>
                                        <td>{{$return_concept->unitType->code}} - {{$return_concept->unitType->name}}</td>
                                        <td>{{$return_concept->concept}}</td>
                                        <td>{{$return_concept->description}}</td>
                                        <td>{{number_format($return_concept->unit_price, 2, '.', ',')}}</td>
                                        <td>{{number_format($return_concept->amount * $return_concept->unit_price, 2, '.', ',')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <hr>
                        <p><b>Formas de retorno</b></p>
                        <table class="table">
                            <thead>
                                <th>Beneficiario</th>
                                <th>Banco</th>
                                <th>Forma</th>
                                <th>CLABE o Cuenta</th>
                                <th>Monto</th>
                                <th>Referencia</th>
                            </thead>
                            <tbody>
                                @foreach ($return_request->returnTypes as $return_type)
                                    <tr>
                                        <td>{{$return_type->beneficiary_name}}</td>
                                        <td>{{$return_type->bank->name}}</td>
                                        <td>{{$return_type->returnType->name}}</td>
                                        <td>{{$return_type->account_number}}</td>
                                        <td>{{number_format($return_type->amount, 2, '.', ',')}}</td>
                                        <td>{{$return_type->reference}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="d-flex justify-content-end gap-2 m-3">
                        <a href="{{route('return_requests.index')}}" class="btn btn-dark">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>