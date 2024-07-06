$(document).ready(function(){

    window.LaravelDataTables = window.LaravelDataTables || {};

    function onSelectCompany() {
        const company_id = $("#company_id").val();

        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/companies/getAccountsByCompanyId/${company_id}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                $("#account_id").empty().append(addAccountOptions(response))
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        });

        //Verificar si es por parte de caballero y agregar campo para seleccionar a que cuenta se quiere recibir el dinero
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/companies/getById/${company_id}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                //El id 1 es el de caballero, se opera diferente
                if (response.intermediary_id == 1) {
                    setAutocompleteAccountDestiny()
                    $("#account_destiny_input").fadeIn("slow")
                }
                console.log(response);
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        });
    }

    if ($("#company_id").val() == 1) {
        setAutocompleteAccountDestiny()
    }

    function setAutocompleteAccountDestiny() {
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/accounts/getDataAutocomplete`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                autocomplete("account_destiny", response, "Buscar...")
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        });
    }

    function onInputCompany() {
        $(`#company_id`).val("")
        $("#account_destiny_input").fadeOut("slow"); 
        $("#account_id").empty().append(addAccountOptions([]))
        $("#account_destiny_name").val("")
        $("#account_destiny_id").val("")
    }

    function addAccountOptions(accounts) {
        let options = `<option disabled="" selected="" value="">Seleccione una opción...</option>`
        accounts.forEach(element => {
            let text = element.bank.name
            if (element.clabe !== null) {
                text += " - " + element.clabe
            }
            if (element.account_number !== null) {
                text = element.bank.name
                text += " - " + element.account_number
            }
            options += `<option value=${element.id}>${text}</option>`
        });
        return options;
    }


    $.ajax({
        url: $('meta[name="app-url"]').attr('content')+`/clients/getDataAutocomplete`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            autocomplete("client", response, "Buscar...")
        },error: function(xhr, textStatus, errorThrown) {
            errorMessage(xhr.status, errorThrown)
        }
    });

    $.ajax({
        url: $('meta[name="app-url"]').attr('content')+`/companies/getDataAutocomplete`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            autocomplete("company", response, "Buscar...", onSelectCompany, onInputCompany)
        },error: function(xhr, textStatus, errorThrown) {
            errorMessage(xhr.status, errorThrown)
        }
    });

    $('#openModal').click(function() {
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/return_requests/getAddReturnTypeModal`,
            method: 'GET',
            success: function(response) {
                $('#addReturnTypeModal .modal-body').html(response);
                $('#addReturnTypeModal').modal('show');
            }
        });
    });

    window.getEditReturnTypeModal = (return_request_return_type_id) => {
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/return_requests/getEditReturnTypeModal/${return_request_return_type_id}`,
            method: 'GET',
            success: function(response) {
                $('#addReturnTypeModal .modal-body').html(response);
                $('#addReturnTypeModal').modal('show');
            }
        });
    }

    $("#returnTypeModal").on("submit", function(e) {
        e.preventDefault();
        const return_request_id = $("#return_request_id").val()
        const return_request_return_type_id = $("#return_request_return_type_id").val()
        const type = $("#type").val()
        let url = $('meta[name="app-url"]').attr('content')+`/return_requests/addReturnRequestType/${return_request_id}`
        let method = "POST"

        if (this.checkValidity()) {
            const form = $("#returnTypeModal").serialize()

            if (type == "edit") {
                url = $('meta[name="app-url"]').attr('content')+`/return_requests/editReturnRequestType/${return_request_return_type_id}`
                method = "PUT"
            }
            $.ajax({
                url: url,
                type: method,
                data: form,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    //Cerrar el modal y actualizar el datatable
                    let dt = window.LaravelDataTables['return_request_return_types-table'];
                    dt.draw(false)
                    $('#addReturnTypeModal').modal('hide');
                },error: function(xhr, textStatus, errorThrown) {
                    errorMessage(xhr.status, errorThrown)
                }
            })
        };
    })

    window.deleteReturnType = (return_request_return_type_id) => {
        const confirm = alertYesNo(
            'Eliminar registro',
            '¿Estás seguro de eliminar el registo?'
        );
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/return_requests/deleteReturnRequestType/${return_request_return_type_id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        let dt = window.LaravelDataTables['return_request_return_types-table'];
                        dt.draw(false);
                        snackBar("Forma de retorno eliminada correctamente", "success")
    
                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    }
                });
            }
        })
    }

})