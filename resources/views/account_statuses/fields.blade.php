<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "name",
        "name" => "name",
        "type" => "name",
        "placeholder" => "Nombre...",
        "value" => isset($account_status) ? $account_status->name :  old("name"),
        "label" => "Nombre",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "description",
        "name" => "description",
        "type" => "description",
        "placeholder" => "Descripción...",
        "value" => isset($account_status) ? $account_status->description :  old("description"),
        "label" => "Descripción",
    ])
</div>


<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($account_status) ? $account_status->is_active :  true,
        "label" => "Activo",
    ])
</div>
