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
            "type" => "text",
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

<hr>
<div class="mb-3 mt-3">
    <label>% total de comisiones cobradas al cliente<span class="text-danger">*</span></label>
    <div class="input-group">
        <span class="input-group-text">Bancarización / Flujo / Nóminas</span>
        <input value="{{isset($client) ? $client->comission_ban :  old('comission_ban')}}" step="0.01" type="number" id="comission_ban" name="comission_ban" class="form-control" placeholder="Bancarización" required>
        <input value="{{isset($client) ? $client->comission_flu :  old('comission_flu')}}" step="0.01" type="number" id="comission_flu" name="comission_flu" class="form-control" placeholder="Flujo" required>
        <input value="{{isset($client) ? $client->comission_nom :  old('comission_nom')}}" step="0.01" type="number" id="comission_nom" name="comission_nom" class="form-control" placeholder="Nóminas" required>
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
        ])
    </div>
    <div class="col-8">
        <p id="commission_text" style="margin-top: 35px" class="text-secondary text-center">Las comisiones del promotor se activan al seleccionar un promotor</p>
        <div id="commission_pm" class="d-none">
            <label>% de comisiones que se lleva el promotor</label>
            <div class="input-group">
                <span class="input-group-text">Bancarización / Flujo / Nóminas</span>
                <input value="{{isset($client) ? $client->comission_ban_promotor :  old('comission_ban_promotor')}}" step="0.01" type="number" id="comission_ban_promotor" name="comission_ban_promotor" class="form-control" placeholder="Bancarización">
                <input value="{{isset($client) ? $client->comission_flu_promotor :  old('comission_flu_promotor')}}" step="0.01" type="number" id="comission_flu_promotor" name="comission_flu_promotor" class="form-control" placeholder="Flujo">
                <input value="{{isset($client) ? $client->comission_nom_promotor :  old('comission_nom_promotor')}}" step="0.01" type="number" id="comission_nom_promotor" name="comission_nom_promotor" class="form-control" placeholder="Nóminas">
            </div>
        </div>
    </div>
</div>
<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($client) ? $client->is_active :  true,
        "label" => "Activo",
    ])
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
                <td>{{ $company->intermediary->name ?? "N/A" }}</td>
                <td>{{ $company->companyLevel->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>



