<div class="mb-2 row">
    <div class="col-md-9">
        @include("components.custom.forms.input", [
            "id" => "name",
            "name" => "name",
            "type" => "name",
            "placeholder" => "Nombre...",
            "value" => isset($currency_type) ? $currency_type->name :  old("name"),
            "label" => "Nombre",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-3">
        @include("components.custom.forms.input", [
            "id" => "symbol",
            "name" => "symbol",
            "type" => "symbol",
            "placeholder" => "Nombre...",
            "value" => isset($currency_type) ? $currency_type->symbol :  old("symbol"),
            "label" => "Nombre",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>

<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "description",
        "name" => "description",
        "type" => "description",
        "placeholder" => "Descripción...",
        "value" => isset($currency_type) ? $currency_type->description :  old("description"),
        "label" => "Descripción",
    ])
</div>


<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($currency_type) ? $currency_type->is_active :  true,
        "label" => "Activo",
    ])
</div>
