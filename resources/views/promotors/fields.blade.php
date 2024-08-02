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
    <div class="col-12">
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
</div>

<hr>
<div class="mb-3 mt-3">
    <label>% de comisiones <span class="text-danger">*</span></label>
    <div class="input-group">
        <span class="input-group-text">Bancarización / Flujo / Nóminas</span>
        <input value="{{isset($client) ? $client->comission_ban :  old('comission_ban')}}" type="number" id="comission_ban" name="comission_ban" class="form-control" placeholder="Bancarización" required>
        <input value="{{isset($client) ? $client->comission_flu :  old('comission_flu')}}" type="number" id="comission_flu" name="comission_flu" class="form-control" placeholder="Flujo" required>
        <input value="{{isset($client) ? $client->comission_nom :  old('comission_nom')}}" type="number" id="comission_nom" name="comission_nom" class="form-control" placeholder="Nóminas" required>
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
