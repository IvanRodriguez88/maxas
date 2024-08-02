<div class="row mb-2">
    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "email",
            "name" => "email",
            "type" => "email",
            "placeholder" => "Email...",
            "value" => isset($client) ? $client->user->email :  old("email"),
            "label" => "Email",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "password",
            "name" => "password",
            "type" => "password",
            "placeholder" => "Contraseña...",
            "label" => "Contraseña",
        ])
    </div>
</div>


<div class="row mb-2">
    <div class="col-md-6">
        @include("components.custom.forms.input", [
            "id" => "name",
            "name" => "name",
            "type" => "text",
            "placeholder" => "Nombre...",
            "value" => isset($intermediary) ? $intermediary->name :  old("name"),
            "label" => "Nombre",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-6">
        @include("components.custom.forms.input", [
            "id" => "comission_percentage",
            "name" => "comission_percentage",
            "type" => "number",
            "placeholder" => "% Comisión cobrada...",
            "value" => isset($intermediary) ? $intermediary->comission_percentage :  old("comission_percentage"),
            "label" => "% Comisión cobrada",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>


<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($intermediary) ? $intermediary->is_active :  true,
        "label" => "Activo",
    ])
</div>
