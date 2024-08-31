$(document).ready(function(){

    window.LaravelDataTables = window.LaravelDataTables || {};

    window.addReturnRequest = () => {
        const confirm = alertYesNo(
            'Solicitud de retorno',
            '¿Estás seguro de abrir una nueva solicitud?'
        );
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/return_requests/addReturnRequest`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        console.log(response);
                        snackBar("Concepto eliminado correctamente", "success")
                        setInterval(() => {
                            // window.location.href = $('meta[name="app-url"]').attr('content')+`/return_requests/invoices/${response.id}`
                        }, 1000);
    
                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    }
                });
            }
        })
    }

    
})