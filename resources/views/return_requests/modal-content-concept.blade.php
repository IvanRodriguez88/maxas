<input type="hidden" id="type" value="{{$type}}">
<input type="hidden" id="return_request_concept_id" value="{{isset($return_request_concept) ? $return_request_concept->id : ''}}">

<div class="row mb-2">
    <div class="col-sm-3">
        @include("components.custom.forms.input", [
            "id" => "amount",
            "name" => "amount",
            "type" => "number",
            "placeholder" => "Cantidad...",
            "value" => isset($return_request_concept) ? $return_request_concept->amount :  old("amount"),
            "label" => "Cantidad",
            "required" => true,
        ])
    </div>
    <div class="col-sm-6">
        @include("components.custom.forms.input-select", [
            "id" => "unit_type_id",
            "name" => "unit_type_id",
            "elements" => $unitTypes,
            "value" => isset($return_request_concept) ? $return_request_concept->unit_type_id :  old("unit_type_id"),
            "label" => "Unidad",
            "required" => true,
        ])
    </div>
    <div class="col-sm-3">
        @include("components.custom.forms.input", [
            "id" => "unit_price",
            "name" => "unit_price",
            "type" => "number",
            "placeholder" => "Precio unitario...",
            "value" => isset($return_request_concept) ? $return_request_concept->unit_price :  old("unit_price"),
            "label" => "Precio unitario",
            "required" => true,
        ])
    </div>
</div>

<div class="row mb-2">
    <div class="col-sm-6">
        @include("components.custom.forms.input", [
            "id" => "concept",
            "name" => "concept",
            "type" => "text",
            "placeholder" => "Concepto...",
            "value" => isset($return_request_concept) ? $return_request_concept->concept :  old("concept"),
            "label" => "Concepto",
            "required" => true,
        ])
    </div>
    <div class="col-sm-6">
        @include("components.custom.forms.input", [
            "id" => "description",
            "name" => "description",
            "type" => "text",
            "placeholder" => "Descripción...",
            "value" => isset($return_request_concept) ? $return_request_concept->description :  old("description"),
            "label" => "Descripción",
            "required" => true,
        ])
    </div>
    
</div>