<div class="row mb-2">
    <div class="col-md-9">
        @include("components.custom.forms.input", [
            "id" => "name",
            "name" => "name",
            "type" => "text",
            "placeholder" => "Nombre...",
            "value" => isset($company) ? $company->name :  old("name"),
            "label" => "Nombre",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-3">
        @include("components.custom.forms.input", [
            "id" => "comission",
            "name" => "comission",
            "type" => "text",
            "placeholder" => "Comisión...",
            "value" => isset($company) ? $company->comission :  old("comission"),
            "label" => "Comisión",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>

<div class="card mt-3 mb-3">
    <div class="card-body">
        <h5 class="card-title">Cuentas vinculadas</h5>
        <div class="autocomplete-btn mb-2">
            <input id="account_name" class="form-control" name="account_name">
            <input type="hidden" name="account_id" id="account_id">
            <button onclick="addAccount()" type="button" class="btn btn-primary">Agregar</button>
        </div>
        <div class="grid-container" id="accountsContainer">
            @if(isset($company))
                @foreach($company->accounts as $account)
                    @include("companies.account_card", $account)
                @endforeach
            @endif
        </div>
    </div>
</div>

<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "social_object",
        "name" => "social_object",
        "type" => "textarea",
        "placeholder" => "Objeto social...",
        "value" => isset($company) ? $company->social_object :  old("social_object"),
        "label" => "Objeto social",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="row mb-2">
    <div class="col-md-6">
        @include("components.custom.forms.input-select", [
            "id" => "group_id",
            "name" => "group_id",
            "elements" => $groups,
            "value" => isset($company) ? $company->group_id :  old("group_id"),
            "label" => "Grupo",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-6">
        @include("components.custom.forms.input-select", [
            "id" => "bank_separation_id",
            "name" => "bank_separation_id",
            "elements" => $bankSeparations,
            "value" => isset($company) ? $company->bank_separation_id :  old("bank_separation_id"),
            "label" => "Separación de banco",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-4">
        @include("components.custom.forms.input-select", [
            "id" => "account_status_id",
            "name" => "account_status_id",
            "elements" => $accountStatuses,
            "value" => isset($company) ? $company->account_status_id :  old("account_status_id"),
            "label" => "Estatus",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-4">
        @include("components.custom.forms.input-select", [
            "id" => "intermediary_id",
            "name" => "intermediary_id",
            "elements" => $intermediaries,
            "value" => isset($company) ? $company->intermediary_id :  old("intermediary_id"),
            "label" => "Intermediario",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-4">
        @include("components.custom.forms.input-select", [
            "id" => "company_level_id",
            "name" => "company_level_id",
            "elements" => $companyLevels,
            "value" => isset($company) ? $company->company_level_id :  old("company_level_id"),
            "label" => "Nivel de empresa",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>

<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($company) ? $company->is_active :  true,
        "label" => "Activo",
    ])
</div>