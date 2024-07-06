<input type="hidden" id="type" value="{{$type}}">

<div class="row mb-2">
    <div class="col-sm-8">
        @include("components.custom.forms.input-select", [
            "id" => "client_id",
            "name" => "client_id",
            "elements" => $clients,
            "label" => "Cliente",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    
    <div class="col-sm-4">
        @include("components.custom.forms.input", [
            "id" => "commission",
            "name" => "commission",
            "placeholder" => "Comisión",
            "label" => "Comisión",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>
