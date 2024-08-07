<input type="hidden" id="type" value="{{$type}}">
<input type="hidden" id="return_request_return_type_id" value="{{isset($return_request_return_type) ? $return_request_return_type->id : ''}}">

<div class="row mb-2">
    <div class="col-sm-8">
        @include("components.custom.forms.input", [
            "id" => "beneficiary_name",
            "name" => "beneficiary_name",
            "type" => "text",
            "placeholder" => "Nombre del beneficiario...",
            "value" => isset($return_request_return_type) ? $return_request_return_type->beneficiary_name :  old("beneficiary_name"),
            "label" => "Nombre del beneficiario",
            "required" => true,
        ])
    </div>
    
    <div class="col-sm-4">
        @include("components.custom.forms.input-select", [
            "id" => "return_type_id",
            "name" => "return_type_id",
            "elements" => $returnTypes,
            "placeholder" => "Froma de retorno...",
            "value" => isset($return_request_return_type) ? $return_request_return_type->return_type_id :  old("return_type_id"),
            "label" => "Forma de retorno",
            "required" => true,
        ])
    </div>
</div>

<div class="row mb-2">
    <div class="col-sm-3">
        @if (isset($return_request_return_type))
            @if ($return_request_return_type->return_type_id == 1)
                @include("components.custom.forms.input-select", [
                    "id" => "bank_id",
                    "name" => "bank_id",
                    "elements" => $banks,
                    "placeholder" => "Banco...",
                    "value" => isset($return_request_return_type) ? $return_request_return_type->bank_id :  old("bank_id"),
                    "label" => "Banco",
                    "disabled" => true,
                ])
            @else
                @include("components.custom.forms.input-select", [
                    "id" => "bank_id",
                    "name" => "bank_id",
                    "elements" => $banks,
                    "placeholder" => "Banco...",
                    "value" => isset($return_request_return_type) ? $return_request_return_type->bank_id :  old("bank_id"),
                    "label" => "Banco",
                    "required" => true,
                ])
            @endif
        @else
            @include("components.custom.forms.input-select", [
                "id" => "bank_id",
                "name" => "bank_id",
                "elements" => $banks,
                "placeholder" => "Banco...",
                "value" => isset($return_request_return_type) ? $return_request_return_type->bank_id :  old("bank_id"),
                "label" => "Banco",
                "required" => true,
            ])
        @endif
        
    </div>
    <div class="col-sm-6">
        @include("components.custom.forms.input", [
            "id" => "account_number",
            "name" => "account_number",
            "type" => "text",
            "placeholder" => "Cuenta o clabe...",
            "value" => isset($return_request_return_type) ? $return_request_return_type->account_number :  old("account_number"),
            "label" => "Cuenta o clabe",
            "required" => true,

        ])
    </div>
    <div class="col-sm-3">
        @include("components.custom.forms.input", [
            "id" => "amount",
            "name" => "amount",
            "type" => "number",
            "placeholder" => "Monto...",
            "value" => isset($return_request_return_type) ? $return_request_return_type->amount :  old("amount"),
            "label" => "Monto",
            "required" => true,

        ])
    </div>
</div>

<div class="row mb-2">
    <div class="col-sm-6">
        @include("components.custom.forms.input", [
            "id" => "reference",
            "name" => "reference",
            "type" => "textarea",
            "placeholder" => "Referencia...",
            "value" => isset($return_request_return_type) ? $return_request_return_type->reference :  old("reference"),
            "label" => "Referencia",
        ])
    </div>
    <div class="col-sm-6">
        @include("components.custom.forms.input", [
            "id" => "notes",
            "name" => "notes",
            "type" => "textarea",
            "placeholder" => "Notas...",
            "value" => isset($return_request_return_type) ? $return_request_return_type->notes :  old("notes"),
            "label" => "Notas",
        ])
    </div>
</div>

<script>
    $("#return_type_id").on("change", function() {
        if ($(this).val() == 1) {
            $("#bank_id").val("")
            $("#bank_id").attr("disabled", true)
            $("#bank_id").attr("required", false)
        }else {
            $("#bank_id").val("")
            $("#bank_id").attr("disabled", false)
            $("#bank_id").attr("required", true)
        }
    })
</script>