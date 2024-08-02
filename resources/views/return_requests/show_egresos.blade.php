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
                <form id="return_request_egresos-form" class="row g-3 needs-validation" novalidate method="POST" action="{{ route('return_requests.updateEgresos', $return_request->id) }}" enctype="multipart/form-data">
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
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <div>
									<div class="card p-2">
										<input type="hidden" id="total_rest" value="{{$return_request->total_return - $return_request->getTotalReturnedAttribute()}}">
										<p>TOTAL A RETORNAR: <b class="text-success">${{ number_format($return_request->total_return, 2, '.', ',') }}</b></p>
										<p>TOTAL RETORNADO: <b id="total_returned_text" class="text-dark">${{ number_format($return_request->getTotalReturnedAttribute(), 2, '.', ',') }}</b></p>
										<p class="mb-0">TOTAL RESTANTE: 
											<b id="total_rest_text" class="text-secondary">
												${{ number_format($return_request->total_return - $return_request->getTotalReturnedAttribute(), 2, '.', ',') }}
											</b>
										</p>
									</div>
									<div class="mt-3">
										<div class="d-flex input-container">
											<span class="input-group-text">
												Cuenta donde saldrá el dinero
												<b class="text-danger">*</b>
											</span>
											<div class="w-100">
												<select class="form-control" id="account_id" name="account_id" required>
													<option disabled selected value="0">Seleccione una opción...</option>
													@foreach ($accounts as $account)
														@php $text = $account->bank->name; @endphp
						
														@if ($account->clabe !== null)
															@php $text .= " - ".$account->clabe; @endphp
														@endif
						
														@if ($account->account_number !== null)
															@php 
																$text = $account->bank->name;
																$text .= " - ".$account->account_number;
															@endphp
														@endif
														<option value="{{$account->id}}">{{$text}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div id="account_info" class="card p-3">

										</div>
									</div>
								</div>
                                <div>
                                    <div class="btn-group-vertical" role="group" aria-label="Vertical radio toggle button group">
                                        <input checked type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio2" autocomplete="off">
                                        <label class="btn btn-outline-secondary" for="vbtn-radio2">Ver todos</label>

                                        <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio3" autocomplete="off">
                                        <label class="btn btn-outline-secondary" for="vbtn-radio3">Dispersados</label>

                                        <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio4" autocomplete="off">
                                        <label class="btn btn-outline-secondary" for="vbtn-radio4">Sin dispersar</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <p>Formas de retorno</p>
                                {!! $returnRequestReturnTypeDT['view'] !!}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between gap-2 m-3">
                            <a id="btnAccept" class="btn btn-success">Finalizar Solicitud</a>
                            <a href="{{route('return_requests.index')}}" class="btn btn-dark">Regresar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form id="dispersionVoucherModal" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
        <x-modal id="addDispersionVoucherModal" title="Agregar comprobante de dispersión" size="md">
            <!-- Este contenido se llenará por AJAX -->
        </x-modal>
    </form>


    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {!! $returnRequestReturnTypeDT['scripts'] !!}
        @vite(['resources/js/return_requests/return_request_egresos.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>