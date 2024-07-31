$(document).ready(function(){
    $("#return_request_mesa_control-form").on("submit", function(e) {
        e.preventDefault();
        const formData = new FormData($("#return_request_mesa_control-form")[0]);
        
        if (this.checkValidity()) {
            const return_request_id = $("#return_request_id").val()
            const confirm = alertYesNo(
                'Confirmar operación',
                '¿Estás seguro de pasar la solicitud a egresos?',
                'question',
                'Aceptar', 'Cancelar', '#5497d6' ,'#d33333'
            );
            confirm.then((result) => {
                if (result) {
                    $.ajax({
                        url: $('meta[name="app-url"]').attr('content')+`/return_requests/updateMesaControl/${return_request_id}`,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(response) {
                            window.location = $('meta[name="app-url"]').attr('content')+`/return_requests`
                        }
                    });
                }
            })
        }
    })
})