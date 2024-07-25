<div class="mb-2 row">
    <div class="col-md-5">
        @include("components.custom.forms.input-select", [
            "id" => "bank_id",
            "name" => "bank_id",
            "elements" => $banks,
            "value" => isset($account) ? $account->bank_id :  old("bank_id"),
            "label" => "Banco",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-4">
        @include("components.custom.forms.input-select", [
            "id" => "bank_separation_id",
            "name" => "bank_separation_id",
            "elements" => $bankSeparations,
            "value" => isset($company) ? $company->bank_separation_id :  old("bank_separation_id"),
            "label" => "Tipo de banco",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-3">
        @include("components.custom.forms.input-select", [
            "id" => "currency_type_id",
            "name" => "currency_type_id",
            "elements" => $currency_types,
            "value" => isset($account) ? $account->currency_type_id :  old("currency_type_id"),
            "label" => "Moneda",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>

<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "account_number",
        "name" => "account_number",
        "type" => "text",
        "placeholder" => "Número de cuenta...",
        "value" => isset($account) ? $account->account_number :  old("account_number"),
        "label" => "Número de cuenta",
    ])
</div>

<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "clabe",
        "name" => "clabe",
        "type" => "text",
        "placeholder" => "Clabe interbancaria...",
        "value" => isset($account) ? $account->clabe :  old("clabe"),
        "label" => "Clabe interbancaria",
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div id="dls-fields" class="row mb-2 d-none">
    <p class="text-secondary">Para cuentas en dolares se requiere AVA y SWIFT</p>
    <div class="col-md-6">
        @include("components.custom.forms.input", [
            "id" => "ava",
            "name" => "ava",
            "type" => "text",
            "placeholder" => "AVA...",
            "value" => isset($account) ? $account->ava :  old("ava"),
            "label" => "AVA",
            "invalid_feedback" => "El campo es requerido"

        ])
    </div>
    <div class="col-md-6">
        @include("components.custom.forms.input", [
            "id" => "swift",
            "name" => "swift",
            "type" => "text",
            "placeholder" => "SWIFT...",
            "value" => isset($account) ? $account->swift :  old("swift"),
            "label" => "SWIFT",
            "invalid_feedback" => "El campo es requerido"

        ])
    </div>
</div>


<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($account) ? $account->is_active :  true,
        "label" => "Activo",
    ])
</div>


<script>
    $(document).ready(function(){
        $('#account_number').inputmask("999999999999", {
            placeholder: '',
            greedy: false,
            definitions: {
                '9': {
                    validator: "[0-9]",
                    cardinality: 1,
                }
            }
        });

    })
</script>