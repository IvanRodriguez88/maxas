$(document).ready(function(){
    $("#concepts-table").DataTable({
        searching: false, 
        lengthChange: false,
        paging: false
    })
    $("#returns-table").DataTable({
        searching: false, 
        lengthChange: false,
        paging: false
    })
    
    $('#btnAccept').click(function() {
        const confirm = alertYesNo(
            'Confirmar solicitud',
            '¿Estás seguro de pasar la solicitud a fase de ingresos?',
            'question',
            'Aceptar', 'Cancelar', '#5497d6' ,'#d33333'
        );
        confirm.then((result) => {
            if (result) {
                const return_request_id = $("#return_request_id").val()
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/return_requests/changeStatus/${return_request_id}/3`, //3 es el status de Ingresos
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        window.location = $('meta[name="app-url"]').attr('content')+`/return_requests`
                    }
                });
            }
        })
       
    });

    $("#addInvoiceBtn").on("click", function() {
        const formData = new FormData($("#return_request_operaciones-form")[0]);
        const return_request_id = $("#return_request_id").val()
        const confirm = alertYesNo(
            'Subir factura',
            '¿Estás seguro de subir la factura de la solicitud?',
            'question',
            'Aceptar', 'Cancelar', '#5497d6' ,'#d33333'
        );
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/return_requests/addInvoice/${return_request_id}`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        if (response.status) {
                            snackBar(response.message, "success")
                            location.reload()
                        }else{
                            snackBar(response.message, "danger")
                        }
                    }
                });
            }
        })
    })
})