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
            <div class="w-75">
                <form id="return_request_ingresos-form" class="row g-3 needs-validation" novalidate method="POST" action="{{ route('return_requests.updateIngresos', $return_request->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    {!! $return_request->getStatusBadge() !!}
                                    <h5 class="card-title">Solicitud de retorno #{{$return_request->id}}</h5>
                                </div>
                                <div>
                                    <p class="m-0"><b>Fecha solicitado:</b> {{date('d/m/Y H:i:s', strtotime($return_request->date))}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3 d-flex gap-3 justify-content-between">
                                <h4>TOTAL DE FACTURA: <b class="text-success">${{ number_format($return_request->total_invoice, 2, '.', ',') }}</b></h4>
                                @if ($return_request->client_payment_proof !== null)
                                    <div class="mt-4">
                                        <a id="file" target="_blank" href="{{ route('return_requests.downloadClientPaymentProof', $return_request->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                            <u>Comprobante de pago</u>
                                        </a> 
                                    </div> para que hacer esto en la empresa, hoy no creo que haga mucho ejercicio, 
                                @else
                                    <p class="text-danger">Aún no se carga comprobante de pago</p>
                                @endif
                            </div>

                            <div class="d-flex">
                                <div class="p-3 w-50" style="border: 1px solid #bdbdbd; border-radius: 5px">
                                    <p><b>Empresa:</b> {{$return_request->company->name}}</p>
                                    <hr class="m-0 p-0 mb-1">
                                    <p><b>Cuenta en donde se depositó:</b> </p>
                                    <p><b>Banco:</b> {{$return_request->account->bank->name}}</p>
                                    <p><b>CLABE:</b> {{$return_request->account->clabe ?? "N/A"}}</p>
                                    <p><b>Número de cuenta:</b> {{$return_request->account->account_number ?? "N/A"}}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <label for="bank_payment_proof">Comprobante del ingreso en banco <span class="text-danger">*</span></label>
                                <input required type="file" name="bank_payment_proof" id="bank_payment_proof" class="form-control mx-2" accept=".pdf">
                            </div>
                        </div>
						<div class="d-flex justify-content-between gap-2 m-3">
							<button type="submit" class="btn btn-success">Pasar a mesa de control</button>
							<a href="{{route('return_requests.index')}}" class="btn btn-dark">Regresar</a>
						</div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite(['resources/js/return_requests/return_request_ingresos.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>