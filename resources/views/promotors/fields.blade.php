<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "name",
        "name" => "name",
        "type" => "text",
        "placeholder" => "Nombre...",
        "value" => isset($promotor) ? $promotor->name :  old("name"),
        "label" => "Nombre",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "account_number",
        "name" => "account_number",
        "type" => "number",
        "placeholder" => "Número de cuenta o clabe interbancaria...",
        "value" => isset($promotor) ? $promotor->account_number :  old("account_number"),
        "label" => "Cuenta o Clabe",
    ])
</div>

<div class="row mb-2">
    <div class="col-sm-6">
        @include("components.custom.forms.input", [
            "id" => "comission",
            "name" => "comission",
            "type" => "number",
            "placeholder" => "Porcentaje de comisión...",
            "value" => isset($promotor) ? $promotor->comission :  old("comission"),
            "label" => "% Comisión",
        ])
    </div>
    <div class="col-sm-6">
        @include("components.custom.forms.input", [
            "id" => "balance",
            "name" => "balance",
            "type" => "number",
            "placeholder" => "Saldo...",
            "value" => isset($promotor) ? $promotor->balance :  old("balance"),
            "label" => "Saldo",
            "disabled" => true
        ])
    </div>
</div>


<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($promotor) ? $promotor->is_active :  true,
        "label" => "Activo",
    ])
</div>
