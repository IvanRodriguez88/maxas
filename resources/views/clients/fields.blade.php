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
    <div class="col-6">
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
    <div class="col-3">
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
    <div class="col-3">
        @include("components.custom.forms.input-select", [
            "id" => "return_base_id",
            "name" => "return_base_id",
            "elements" => $returnBases,
            "value" => isset($client) ? $client->return_base_id :  old("return_base_id"),
            "label" => "Base de retorno",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>

<div class="row mb-2">
    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "rfc",
            "name" => "rfc",
            "type" => "text",
            "placeholder" => "RFC...",
            "value" => isset($client) ? $client->rfc :  old("rfc"),
            "label" => "RFC",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "street_and_number",
            "name" => "street_and_number",
            "type" => "text",
            "placeholder" => "Calle y número...",
            "value" => isset($client) ? $client->street_and_number :  old("street_and_number"),
            "label" => "Calle y número",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>

<div class="row mb-2">
    <div class="col-3">
        @include("components.custom.forms.input", [
            "id" => "cologne",
            "name" => "cologne",
            "type" => "text",
            "placeholder" => "Colonia...",
            "value" => isset($client) ? $client->cologne :  old("cologne"),
            "label" => "Colonia",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-3">
        @include("components.custom.forms.input", [
            "id" => "state",
            "name" => "state",
            "type" => "text",
            "placeholder" => "Estado...",
            "value" => isset($client) ? $client->state :  old("state"),
            "label" => "Estado",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-3">
        @include("components.custom.forms.input", [
            "id" => "city",
            "name" => "city",
            "type" => "text",
            "placeholder" => "Ciudad...",
            "value" => isset($client) ? $client->city :  old("city"),
            "label" => "Ciudad",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-3">
        @include("components.custom.forms.input", [
            "id" => "postal_code",
            "name" => "postal_code",
            "type" => "text",
            "placeholder" => "Código postal...",
            "value" => isset($client) ? $client->postal_code :  old("postal_code"),
            "label" => "Código postal",
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

<div class="mb-2 row">
    <div class="col-4">
        @include("components.custom.forms.input-select", [
            "id" => "promotor_id",
            "name" => "promotor_id",
            "elements" => $promotors,
            "value" => isset($client) ? $client->promotor_id :  old("promotor_id"),
            "label" => "Promotor",
            "disabled" => false,
        ])
    </div>
    <div class="col-8">
        <p id="commission_text" style="margin-top: 35px" class="text-secondary text-center">Las comisiones cobradas por el proveedor al cliente se activan al seleccionar un proveedor</p>
        <div id="commission_pm" class="d-none">
            <label>% de comisiones cobradas al cliente por el promotor</label>
            <div class="input-group">
                <span class="input-group-text">Bancarización / Flujo / Nóminas</span>
                <input value="{{isset($client) ? $client->comission_ban_promotor :  old('comission_ban_promotor')}}" type="number" id="comission_ban_promotor" name="comission_ban_promotor" class="form-control" placeholder="Bancarización">
                <input value="{{isset($client) ? $client->comission_flu_promotor :  old('comission_flu_promotor')}}" type="number" id="comission_flu_promotor" name="comission_flu_promotor" class="form-control" placeholder="Flujo">
                <input value="{{isset($client) ? $client->comission_nom_promotor :  old('comission_nom_promotor')}}" type="number" id="comission_nom_promotor" name="comission_nom_promotor" class="form-control" placeholder="Nóminas">
            </div>
        </div>
    </div>
</div>

<hr>
<h4>Empresas disponibles para cliente</h4>
<table id="client_companies-table" class="table">
    <thead>
        <tr>
            <th>Seleccionar</th>
            <th>Grupo</th>
            <th>Nombre</th>
            <th>Intermediario</th>
            <th>Nivel</th>

        </tr>
    </thead>
    <tbody>
        @foreach($companies as $company)
            <tr>
                <td>
                    <input 
                        class="text-center w-100" 
                        style="width: 20px; height:20px" 
                        type="checkbox" name="companies[]" value="{{ $company->id }}"
                        {{isset($client) ? $client->hasCompany($company->id) ? "checked" : "" : ""}}
                    >
                </td>
                <td>{{ $company->group->name }}</td>
                <td>{{ $company->name }}</td>
                <td>{{ $company->intermediary->name }}</td>
                <td>{{ $company->companyLevel->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($client) ? $client->is_active :  true,
        "label" => "Activo",
    ])
</div>
