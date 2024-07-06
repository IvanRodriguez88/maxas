<div class="text-center p-2">
    <h5>
        Retorno <b>{{isset($return_request) ? $return_request->id : $lastId + 1 }}</b>
    </h5>
</div>

<div class="row">
    <div class="col-sm-6">
        @include("components.custom.forms.input-inline", [
            "label" => "Cliente",
            "id" => "client_name",
            "type" => "autocomplete",
            "input_hidden" => "client_id",
            "required" => true,
            "value" => isset($return_request) ? $return_request->client->name :  old("client_name"),
            "value_hidden" => isset($return_request) ? $return_request->client_id :  old("client_id")
        ])
        @include("components.custom.forms.input-inline", [
            "label" => "Empresa",
            "id" => "company_name",
            "type" => "autocomplete",
            "input_hidden" => "company_id",
            "required" => true,
            "value" => isset($return_request) ? $return_request->company->name :  old("company_name"),
            "value_hidden" => isset($return_request) ? $return_request->company_id :  old("company_id")
        ])

        <div class="d-flex input-container">
            <span class="input-group-text">Cuenta <b class="text-danger">*</b></span>
            <div class="w-100">
                <select required class="form-control" id="account_id" name="account_id">
                    <option readonly selected value="">Seleccione una opción...</option>
                    @if (isset($return_request))
                        @foreach ($return_request->company->accounts as $account)
                            @php
                                $text = $account->bank->name;
                                if ($account->clabe !== null) {
                                    $text .= " - ".$account->clabe;
                                }                            
                                if ($account->account_number !== null) {
                                    $text = $account->bank->name;
                                    $text .= " - ".$account->account_number;
                                }
                            @endphp
                            <option {{$return_request->account_id == $account->id ? "selected" : ""}} value="{{$account->id}}">{{$text}}</option>
                        @endforeach
                    @endif
                </select>            
            </div>
        </div>

        @php
            $display = "none";
            if (isset($return_request)){
                $account_destiny = $return_request->accountDestiny;
                $text = $account_destiny->bank->name;
                if ($account_destiny->clabe !== null) {
                    $text .= " - ".$account_destiny->clabe;
                } 
                if ($account_destiny->account_number !== null) {
                    $text = $account_destiny->bank->name;
                    $text .= " - ".$account_destiny->account_number;
                }
                if ($return_request->company_id == 1) {
                    $display = "block";
                }
            }

        @endphp
        <div class="mt-2" id="account_destiny_input" style="display:{{$display}}">
            <p class="m-0 text-warning text-center">Esta empresa es operada por caballero. </p>
            <p class="m-0 mb-2 text-warning text-center">Seleccione a que cuenta desea recibir el dinero.</p>
            @include("components.custom.forms.input-inline", [
                "label" => "Cuenta a recibir",
                "id" => "account_destiny_name",
                "type" => "autocomplete",
                "input_hidden" => "account_destiny_id",
                "required" => true,
                "value" => isset($return_request) ? $text :  old("account_destiny_name"),
                "value_hidden" => isset($return_request) ? $return_request->account_destiny_id :  old("account_destiny_id")
            ])
        </div>
        
        @include("components.custom.forms.input-inline-select", [
            "id" => "return_base_id",
            "name" => "return_base_id",
            "elements" => $returnBases,
            "placeholder" => "Descripción...",
            "value" => isset($return_request) ? $return_request->return_base_id :  old("return_base_id"),
            "label" => "Base de retorno",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
        <hr>
        @include("components.custom.forms.input-inline-select", [
            "id" => "promotor_id",
            "name" => "promotor_id",
            "elements" => $promotors,
            "value" => isset($return_request) ? $return_request->promotor_id :  old("promotor_id"),
            "label" => "Promotor",
            "invalid_feedback" => "El campo es requerido"
        ])
        @include("components.custom.forms.input-inline", [
            "label" => "Total factura",
            "id" => "total_invoice",
            "type" => "number",
            "required" => true,
            "value" => isset($return_request) ? $return_request->total_invoice :  old("total_invoice"),
        ])
        @include("components.custom.forms.input-inline", [
            "label" => "Total a retornar",
            "id" => "total_return",
            "type" => "number",
            "readonly" => true,
            "value" => isset($return_request) ? $return_request->total_return :  old("total_return"),
        ])

        <div class="mt-3 mb-2">
            <div class="d-flex align-items-center gap-2">
                <div class="w-75">
                    <label for="client_payment_proof">Comprobante de pago del cliente *pdf</label>
                    <input accept="application/pdf" {{isset($return_request) ? '' : 'required'}} class="form-control" type="file" name="client_payment_proof" id="client_payment_proof">
                </div>
                <div class="mt-4">
                    @if (isset($return_request))
                    <a href="{{route('return_requests.downloadClientPaymentProof', $return_request->id)}}" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Ver pdf
                    </a>
                    @endif
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-sm-6">
        @include("components.custom.forms.input-inline", [
            "label" => "Fecha",
            "id" => "date",
            "type" => "date",
            "value" => isset($return_request) ? $return_request->date :  date("Y-m-d"),
            "readonly" => true
        ])
        @include("components.custom.forms.input-inline", [
            "label" => "Factura",
            "id" => "invoice",
            "type" => "text",
            "value" => isset($return_request) ? $return_request->invoice :  old("invoice"),
        ])
        @include("components.custom.forms.input-inline", [
            "label" => "Retorno play",
            "id" => "play_return",
            "type" => "number",
            "readonly" => true,
            "value" => isset($return_request) ? $return_request->play_return :  old("play_return"),
        ])
        @include("components.custom.forms.input-inline", [
            "label" => "Cab .5% sobre T",
            "id" => "cab5T",
            "type" => "number",
            "readonly" => true,
            "value" => isset($return_request) ? $return_request->cab5T :  old("cab5T"),

        ])
        @include("components.custom.forms.input-inline", [
            "label" => "% de retorno",
            "id" => "return_percentage",
            "type" => "number",
            "required" => true,
            "value" => isset($return_request) ? $return_request->return_percentage :  old("return_percentage"),
        ])
        @include("components.custom.forms.input-inline", [
            "label" => "Comisión promotor",
            "id" => "comission_promotor",
            "type" => "number",
            "readonly" => true,
            "value" => isset($return_request) ? $return_request->comission_promotor :  old("comission_promotor"),
        ])
        @include("components.custom.forms.input-inline", [
            "label" => "Comisión caballero",
            "id" => "comission_cab",
            "type" => "number",
            "readonly" => true,
            "value" => isset($return_request) ? $return_request->comission_cab :  old("comission_cab"),
        ])
        @include("components.custom.forms.input-inline", [
            "label" => "Comisión play",
            "id" => "comission_play",
            "type" => "number",
            "readonly" => true,
            "value" => isset($return_request) ? $return_request->comission_play :  old("comission_play"),
        ])
        @include("components.custom.forms.input-inline", [
            "label" => "Comisión cobrada",
            "id" => "comission_charged",
            "type" => "number",
            "readonly" => true,
            "value" => isset($return_request) ? $return_request->comission_charged :  old("comission_charged"),
        ])
        @include("components.custom.forms.input-inline", [
            "label" => "IVA",
            "id" => "iva",
            "type" => "number",
            "readonly" => true,
            "value" => isset($return_request) ? $return_request->iva :  old("iva"),
        ])
        @include("components.custom.forms.input-inline", [
            "label" => "Costo social",
            "id" => "social_cost",
            "type" => "number",
            "readonly" => true,
            "value" => isset($return_request) ? $return_request->social_cost :  old("social_cost"),
        ])
    </div>
</div>

<div class="mb-2">

</div>

<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($return_request) ? $return_request->is_active :  true,
        "label" => "Activo",
    ])
</div>
