$(document).ready(function(){

    window.LaravelDataTables = window.LaravelDataTables || {};

    $("#client_business_id").on("change", fetchClientBusinessData);
    
    if ($("#type").val() != "create") {
        $("#client_business_id").trigger("change");
        
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
    

    $('#openModalTypes').click(function() {
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
                    $("#total_return_types").html(`$ ${formatNumber(response.data.total_sum_return_type)}`)
                    $("#rest_types").html(`$ ${formatNumber(response.data.total_return - response.data.total_sum_return_type)}`)
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
                        $("#total_return_types").html(`$ ${formatNumber(response.data.total_sum_return_type)}`)
                        $("#rest_types").html(`$ ${formatNumber(response.data.total_return - response.data.total_sum_return_type)}`)
                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    }
                });
            }
        })
    }

    //Para conceptos
    $('#openModalConcepts').click(function() {
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/return_requests/getAddReturnConceptModal`,
            method: 'GET',
            success: function(response) {
                $('#addReturnConceptModal .modal-body').html(response);
                $('#addReturnConceptModal').modal('show');
            }
        });
    });

    window.getEditReturnConceptModal = (return_request_concept_id) => {
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/return_requests/getEditReturnConceptModal/${return_request_concept_id}`,
            method: 'GET',
            success: function(response) {
                $('#addReturnConceptModal .modal-body').html(response);
                $('#addReturnConceptModal').modal('show');
            }
        });
    }

    $("#returnConceptModal").on("submit", function(e) {
        e.preventDefault();
        const return_request_id = $("#return_request_id").val()
        const return_request_concept_id = $("#return_request_concept_id").val()
        const type = $("#type").val()
        let url = $('meta[name="app-url"]').attr('content')+`/return_requests/addReturnRequestConcept/${return_request_id}`
        let method = "POST"

        if (this.checkValidity()) {
            const form = $("#returnConceptModal").serialize()

            if (type == "edit") {
                url = $('meta[name="app-url"]').attr('content')+`/return_requests/editReturnRequestConcept/${return_request_concept_id}`
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
                    let dt = window.LaravelDataTables['return_request_concepts-table'];
                    dt.draw(false)
                    $('#addReturnConceptModal').modal('hide');
                    $("#subtotal").html(`$ ${formatNumber(response.data.subtotal)}`)
                    $("#iva").html(`$ ${formatNumber(response.data.iva)}`)
                    $("#total").html(`$ ${formatNumber(response.data.total_invoice)}`)
                    $("#total_return").html(`$ ${formatNumber(response.data.total_return)}`)

                    //Actualizar la tabla de cantidades
                    console.log(response);
                },error: function(xhr, textStatus, errorThrown) {
                    errorMessage(xhr.status, errorThrown)
                }
            })
        };
    })

    window.deleteReturnConcept = (return_request_concept_id) => {
        const confirm = alertYesNo(
            'Eliminar registro',
            '¿Estás seguro de eliminar el registo?'
        );
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/return_requests/deleteReturnRequestConcept/${return_request_concept_id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        let dt = window.LaravelDataTables['return_request_concepts-table'];
                        dt.draw(false);
                        $("#subtotal").html(`$ ${formatNumber(response.data.subtotal)}`)
                        $("#iva").html(`$ ${formatNumber(response.data.iva)}`)
                        $("#total").html(`$ ${formatNumber(response.data.total_invoice)}`)
                        $("#total_return").html(`$ ${formatNumber(response.data.total_return)}`)
                        snackBar("Concepto eliminado correctamente", "success")
    
                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    }
                });
            }
        })
    }

    function fetchClientBusinessData() {
        const client_business_id = $("#client_business_id").val();
        $.ajax({
            url: $('meta[name="app-url"]').attr('content') + `/clients/getClientBusinessDataById/${client_business_id}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                completeBusinessData(response);
            },
            error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown);
            }
        });
    }
    
    function completeBusinessData(data) {
        $("#info-business span").each(function(index, element) {
            const id = $(element).attr('id');
            $(`#${id}`).text(data[id])
        })
        let url = $('meta[name="app-url"]').attr('content') + "/clients/downloadBusinessFile/" + data.id
        $("#file").attr("href", url)
        $("#info-business").removeClass("d-none")
        $("#select-business-message").addClass("d-none")
    }

    $("#company_id").on("change", function(e){
        const company_id = $(this).val()

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

    })


    
})