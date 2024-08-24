$(document).ready(function(){
    $("#client_companies-table").DataTable({
        searching: false, 
        lengthChange: false,
        paging: false
    })

    if($("#promotor_id").val() > 0) {
        $("#commission_text").addClass("d-none")
        $("#commission_pm").removeClass("d-none")
    }

    //Al seleccionar un proveedor se mustran las comisiones
    $("#promotor_id").on("change", function() {
        const promotorId = $(this).val()
        if (promotorId > 0) {
            $("#commission_text").addClass("d-none")
            $("#commission_pm").removeClass("d-none")
        }else{
            $("#commission_text").removeClass("d-none")
            $("#commission_pm").addClass("d-none")
        }
    })


    $('#openModal').click(function() {
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/clients/getAddClientBusinessModal`,
            method: 'GET',
            success: function(response) {
                $('#addClientBusinessModal .modal-body').html(response);
                $('#addClientBusinessModal').modal('show');
            }
        });
    });

    window.getEditClientBusinessModal = (client_business_id) => {
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/clients/getEditClientBusinessModal/${client_business_id}`,
            method: 'GET',
            success: function(response) {
                $('#addClientBusinessModal .modal-body').html(response);
                $('#addClientBusinessModal').modal('show');
            }
        });
    }

    $("#clientBusinessModalForm").on("submit", function(e) {
        e.preventDefault();
        const client_id = $("#client_id").val()
        const client_business_id = $("#client_business_id").val()
        const type = $("#type").val()
        let url = $('meta[name="app-url"]').attr('content')+`/clients/addClientBusiness/${client_id}`
        let method = "POST"

        if (this.checkValidity()) {
            const formData = new FormData($("#clientBusinessModalForm")[0]);
            
            if (type == "edit") {
                url = $('meta[name="app-url"]').attr('content')+`/clients/editClientBusiness/${client_business_id}`
                method = "POST"
            }
            
            $.ajax({
                url: url,
                type: method,
                data: formData,
                contentType: false, // Importante: no establecer contentType a false
                processData: false, // Importante: no procesar los dato
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    //Cerrar el modal y actualizar el datatable
                    let dt = window.LaravelDataTables['client_business-table'];
                    dt.draw(false)
                    $('#addClientBusinessModal').modal('hide');
                },error: function(xhr, textStatus, errorThrown) {
                    errorMessage(xhr.status, errorThrown)
                }
            })
        };
    })

    window.deleteClientBusiness = (client_business_id) => {
        const confirm = alertYesNo(
            'Eliminar registro',
            '¿Estás seguro de eliminar el registo?'
        );
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/clients/deleteClientBusiness/${client_business_id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        let dt = window.LaravelDataTables['client_business-table'];
                        dt.draw(false);
                        snackBar("Razón social eliminada correctamente", "success")
    
                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    }
                });
            }
        })
    }
})