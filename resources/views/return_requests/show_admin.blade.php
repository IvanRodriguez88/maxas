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
        <input type="hidden" id="return_request_id" value="{{ $return_request->id }}">
        <div class="d-flex justify-content-center">
            <div class="w-100">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                           <div>
                               {!! $return_request->getStatusBadge() !!}
                               <h5 class="card-title">Solicitud de retorno #{{$return_request->id}}</h5>
                           </div>
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
                        <div class="card p-3">
                            <h5>Estado</h5>
                            <ul>
                                @if ($return_request->bank_payment_proof == null)
                                    <li class="text-warning">Falta comprobante de ingreso bancario</li>
                                @else
                                    <li class="text-success">Comprobante de ingreso bancario completado</li>
                                @endif

                                @if ($return_request->getEmptyDispersionVoucherFiles() > 0)
                                    <li class="text-warning">Faltan: <b>{{$return_request->getEmptyDispersionVoucherFiles()}}</b> comprobantes de dispersión.</li>
                                @else
                                    <li class="text-success">Comprobantes de dispersión completos</li>
                                @endif

                                @if ($return_request->requires_invoice)
                                    @if($return_request->invoice == null)
                                        <li class="text-warning">Falta adjuntar la factura para el cliente</li>
                                    @else
                                        <li class="text-success">Factura completada</li>
                                    @endif
                                @endif
                            </ul>
                            
                        </div>
                        <hr>
                        <div class="d-flex gap-3">
                            <div>
                                <p><b>Cliente:</b> {{ $return_request->clientBusiness->client->name }}</p>
                                <p><b>Razón social:</b> {{ $return_request->clientBusiness->business_name }}</p>
                                <p><b>RFC:</b> {{ $return_request->clientBusiness->rfc }}</p>
                                <p><b>Estado</b>: {{ $return_request->clientBusiness->state }}</p>
                                <p><b>Ciudad:</b> {{ $return_request->clientBusiness->city }}</p>
                            </div>
                            <div>
                                <p><b>Calle y número:</b> {{ $return_request->clientBusiness->street_and_number }}</p>
                                <p><b>Código postal:</b> {{ $return_request->clientBusiness->postal_code }}</p>
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
                        <div>
                            <p><b>Froma de pago:</b> {{$return_request->paymentWay->name}}</p>
                            <p><b>Método de pago:</b> {{$return_request->paymentMethod->name}} - {{$return_request->paymentMethod->description}}</p>
                            <p><b>Tipo CFDI:</b> INGRESO</p>
                            <p><b>Uso de CFDI:</b> {{$return_request->cfdiUse->code}} - {{$return_request->cfdiUse->name}}</p>
                            <p><b>Cuenta de origen:</b> {{$return_request->origin_account}}</p>
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
                        <div class="row mt-3">
                            <div class="col-md-7">
                                <table class="table-custom">
                                    <tbody>
                                        <tr>
                                            <td>TOTAL A RETORNAR</td>
                                            <td>${{ number_format($return_request->total_return, 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <td>COSTO SOCIAL</td>
                                            <td>${{ number_format($return_request->social_cost, 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <td>COMISIÓN COBRADA</td>
                                            <td>${{ number_format($return_request->comission_charged, 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <td>COMISIÓN PLAY</td>
                                            <td>${{ number_format($return_request->comission_play, 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <td>COMISIÓN PROMOTOR</td>
                                            <td>${{ number_format($return_request->comission_promotor, 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <td>COMISIÓN TERCERO</td>
                                            <td>${{ number_format($return_request->comission_intermediary, 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <td>RETORNO PLAY</td>
                                            <td>${{ number_format($return_request->play_return, 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>TOTAL DE FACTURA</b></td>
                                            <td><b>${{ number_format($return_request->total_invoice, 2, '.', ',') }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-5">
                                <p><b>Base de retorno:</b> {{$return_request->returnBase->name}}</p>
                                <p><b>Porcentaje de retorno:</b> {{$return_request->return_percentage}}%</p>
                                <p><b>Comisión play:</b> {{$return_request->return_percentage_play}}%</p>
                                <p><b>Comisión promotor:</b> {{$return_request->return_percentage_promotor}}%</p>

                                @if ($return_request->intermediary_id != null)
                                    <p><b>Comisión {{$return_request->intermediary->name}} sobre T:</b> {{$return_request->return_percentage_intermediary}}%</p>
                                    <p class="text-secondary">La comisión de {{$return_request->intermediary->name}} es tomada del % total de Play</p>
                                @else
                                    <p>Sin terceros (intermediarios)</p>
                                @endif
                                <div class="mt-4">
                                        <a target="_blank" href="{{ route('return_requests.downloadClientPaymentProof', $return_request->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                            <u>Comprobante de pago de cliente</u>
                                        </a>
                                </div>
                                @if ($return_request->bank_payment_proof != null)
                                    <div class="mt-4">
                                        <a target="_blank" href="{{ route('return_requests.downloadBankPaymentProof', $return_request->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                            <u>Comprobante de ingreso bancario</u>
                                        </a>
                                    </div>
                                @else
                                    <p class="mt-4 text-warning">Aún no hay un comprobante de ingreso bancario</p>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <p><b>Conceptos</b></p>
                            <table id="concepts-table" class="table dataTable no-footer">
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
                                            <td>${{number_format($return_concept->unit_price, 2, '.', ',')}}</td>
                                            <td>${{number_format($return_concept->amount * $return_concept->unit_price, 2, '.', ',')}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        <hr>
                        <p><b>Formas de retorno</b></p>
                        <table id="returns-table" class="table">
                            <thead>
                                <th>Beneficiario</th>
                                <th>Banco</th>
                                <th>Forma</th>
                                <th>CLABE o Cuenta</th>
                                <th>Monto</th>
                                <th>Referencia</th>
                                <th>Cbnte.</th>
                            </thead>
                            <tbody>
                                @foreach ($return_request->returnTypes as $return_type)
                                    <tr>
                                        <td>{{$return_type->beneficiary_name}}</td>
                                        <td>{{$return_type->bank->name}}</td>
                                        <td>{{$return_type->returnType->name}}</td>
                                        <td>{{$return_type->account_number}}</td>
                                        <td>${{number_format($return_type->amount, 2, '.', ',')}}</td>
                                        <td>{{$return_type->reference}}</td>
                                        @if ($return_type->dispersion_voucher_file != null)
                                            <td>
                                                <a id="file" target="_blank" href="{{route('return_requests.downloadDispersionVoucherFile', $return_type->id)}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                                </a>
                                            </td>
                                        @else
                                            <td>
                                                <span class="badge badge-danger mb-2 me-4">Faltante</span>
                                            </td>
                                        @endif
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