<input type="hidden" id="type" value="{{$type}}">
<input type="hidden" id="client_business_id" value="{{isset($client_business) ? $client_business->id : ''}}">

<div class="row mb-2">
    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "business_name",
            "name" => "business_name",
            "type" => "text",
            "placeholder" => "Razón social...",
            "value" => isset($client_business) ? $client_business->business_name :  old("business_name"),
            "label" => "Razón social",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-6">
        <label for="file">Constancia de situación fiscal</label>
        <input name="file" class="form-control" type="file" id="file" accept=".pdf">
        @if($type == "edit")
            @if(isset($client_business))
                <div class="text-end m-1">
                    <a target="_blank" class="text-secondary" href="{{route('clients.downloadBusinessFile', $client_business->id)}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>    
                        {{$client_business->file}}
                    </a>
                </div>
            @endif
        @endif
    </div>
</div>
<div class="row mb-2">
    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "rfc",
            "name" => "rfc",
            "type" => "text",
            "placeholder" => "RFC...",
            "value" => isset($client_business) ? $client_business->rfc :  old("rfc"),
            "label" => "RFC",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "street_and_number",
            "name" => "street_and_number",
            "type" => "text",
            "placeholder" => "Calle y número...",
            "value" => isset($client_business) ? $client_business->street_and_number :  old("street_and_number"),
            "label" => "Calle y número",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>

<div class="row mb-2">
    
    <div class="col-3">
        @include("components.custom.forms.input", [
            "id" => "state",
            "name" => "state",
            "type" => "text",
            "placeholder" => "Estado...",
            "value" => isset($client_business) ? $client_business->state :  old("state"),
            "label" => "Estado",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-3">
        @include("components.custom.forms.input", [
            "id" => "city",
            "name" => "city",
            "type" => "text",
            "placeholder" => "Ciudad...",
            "value" => isset($client_business) ? $client_business->city :  old("city"),
            "label" => "Ciudad",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-3">
        @include("components.custom.forms.input", [
            "id" => "cologne",
            "name" => "cologne",
            "type" => "text",
            "placeholder" => "Colonia...",
            "value" => isset($client_business) ? $client_business->cologne :  old("cologne"),
            "label" => "Colonia",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-3">
        @include("components.custom.forms.input", [
            "id" => "postal_code",
            "name" => "postal_code",
            "type" => "text",
            "placeholder" => "Código postal...",
            "value" => isset($client_business) ? $client_business->postal_code :  old("postal_code"),
            "label" => "Código postal",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>