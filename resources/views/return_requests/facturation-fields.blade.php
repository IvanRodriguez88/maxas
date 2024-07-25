<p><b>Datos de facturación</b></p>
@if (isset($client))

    <div class="row">
        <div class="col-md-8">
            <div class="card p-3">
                @include("components.custom.forms.input-inline-select", [
                    "id" => "client_business_id",
                    "name" => "client_business_id",
                    "elements" => $client->clientBusinesses->pluck("business_name", "id"),
                    "value" => isset($return_request) ? $return_request->client_business_id :  old("client_business_id"),
                    "label" => "Razón social",
                    "required" => true,
                    "invalid_feedback" => "El campo es requerido"
                ])
                <hr>

                <p id="select-business-message" class="text-center text-secondary">Seleccione la razón social a la que quiere facturar</p>
                <div class="d-flex justify-content-between d-none" id="info-business">
                    <div class="w-50">
                        <p><b>Razón social:</b> <span id="business_name"></span></p>
                        <p><b>RFC:</b> <span id="rfc"></span></p>
                        <p><b>Estado</b>: <span id="state"></span></p>
                        <p><b>Ciudad:</b> <span id="city"></span></p>
                    </div>
                    <div class="w-50">
                        <p><b>Código postal:</b> <span id="postal_code"></span></p>
                        <p><b>Calle y número:</b> <span id="street_and_number"></span></p>
                        <p><b>Colonia:</b> <span id="cologne"></span></p>
                        <a id="file" target="_blank">
                            <u>Constancia de situación fiscal</u>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <p><b>Nombre:</b> {{$client->name}}</p>
                <p><b>Promotor:</b> {{isset($return_request) ? $return_request->promotor->name ?? "N/A" : $client->promotor->name}}</p>
                <p><b>Base de retorno:</b> {{$client->returnBase->name}}</p>
            </div>
            <div class="mt-2 ms-1">
                @include("components.custom.forms.input-check", [
                    "id" => "requires_invoice",
                    "name" => "requires_invoice",
                    "checked" => isset($return_request) ? $return_request->requires_invoice :  true,
                    "label" => "Requiero factura",
                ])
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            @include("components.custom.forms.input-inline-select", [
                "id" => "company_id",
                "name" => "company_id",
                "elements" => $companies,
                "value" => isset($return_request) ? $return_request->company_id :  old("company_id"),
                "label" => "Empresa",
                "required" => true,
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
        <div class="col-md-6">
                
            <div class="d-flex input-container">
                <span class="input-group-text">
                    Cuenta a depositar
                    <b class="text-danger">*</b>
                </span>
                <div class="w-100">
                    <select class="form-control" id="account_id" name="account_id" required>
                        <option disabled selected value="">Seleccione una opción...</option>
                        @if (isset($return_request))
                            @foreach ($return_request->company->accounts as $account)
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
                                <option {{$account->id == $return_request->account_id ? "selected" : ""}}  value="{{$account->id}}">{{$text}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>

    <hr>
    
    <div class="row">
        <div class="col-md-6">
            @include("components.custom.forms.input-inline-select", [
                "id" => "payment_method_id",
                "name" => "payment_method_id",
                "elements" => $paymentMethods,
                "value" => isset($return_request) ? $return_request->payment_method_id :  old("payment_method_id"),
                "label" => "Método de pago",
                "required" => true,
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
        <div class="col-md-6">
            @include("components.custom.forms.input-inline-select", [
                "id" => "payment_way_id",
                "name" => "payment_way_id",
                "elements" => $paymentWays,
                "value" => isset($return_request) ? $return_request->payment_way_id :  old("payment_way_id"),
                "label" => "Forma de pago",
                "required" => true,
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @include("components.custom.forms.input-inline", [
                "id" => "cfdi_type",
                "name" => "cfdi_type",
                "type" => "text",
                "value" => "INGRESO",
                "label" => "Tipo de CFDI",
                "disabled" => true
            ])
        </div>
        <div class="col-md-6">
            @include("components.custom.forms.input-inline-select", [
                "id" => "cfdi_use_id",
                "name" => "cfdi_use_id",
                "elements" => $cfdiUses,
                "value" => isset($return_request) ? $return_request->cfdi_use_id :  old("cfdi_use_id"),
                "label" => "Uso CFDI",
                "required" => true,
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @include("components.custom.forms.input-inline", [
                "id" => "origin_account",
                "name" => "origin_account",
                "type" => "text",
                "value" => isset($return_request) ? $return_request->origin_account :  old("origin_account"),
                "label" => "Cuenta de origen",
                "required" => true,
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
        <div class="col-md-6">
            @include("components.custom.forms.input-inline-select", [
                "id" => "request_type_id",
                "name" => "request_type_id",
                "elements" => $requestTypes,
                "value" => isset($return_request) ? $return_request->request_type_id :  old("request_type_id"),
                "label" => "Tipo de solicitud",
                "required" => true,
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
    </div>

@endif