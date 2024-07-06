<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "name",
        "name" => "name",
        "type" => "name",
        "placeholder" => "Nombre...",
        "value" => isset($company_level) ? $company_level->name :  old("name"),
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
        "value" => isset($company_level) ? $company_level->description :  old("description"),
        "label" => "Descripción",
    ])
</div>


<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($company_level) ? $company_level->is_active :  true,
        "label" => "Activo",
    ])
</div>
