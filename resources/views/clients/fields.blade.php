<div class="row mb-2">
    <div class="col-8">
        @include("components.custom.forms.input", [
            "id" => "name",
            "name" => "name",
            "type" => "name",
            "placeholder" => "Nombre...",
            "value" => isset($client) ? $client->name :  old("name"),
            "label" => "Nombre",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-4">
        @include("components.custom.forms.input-select", [
            "id" => "client_type_id",
            "name" => "client_type_id",
            "elements" => $clientTypes,
            "value" => isset($client) ? $client->client_type_id :  old("client_type_id"),
            "label" => "Tipo de cliente",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

</div>

<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "email",
        "name" => "email",
        "type" => "email",
        "placeholder" => "Email...",
        "value" => isset($user) ? $user->email :  old("email"),
        "label" => "Email",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
</div>


<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "password",
        "name" => "password",
        "type" => "password",
        "placeholder" => "Contraseña...",
        "label" => "Contraseña",
    ])
</div>


<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($client) ? $client->is_active :  true,
        "label" => "Activo",
    ])
</div>
