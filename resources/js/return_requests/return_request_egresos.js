$(document).ready(function(){
    $("#btnAccept").click(function() {
        let header = "Dispersiones completas"
        let message = "¿Estás seguro de finalizar la solicitud?"
        if ($("#total_rest").val() > 0 ) {
            header = `Faltan $${formatNumber($("#total_rest").val())}`
        }
        const return_request_id = $("#return_request_id").val()
        const confirm = alertYesNo(
            header,
            message,
            'question',
            'Aceptar', 'Cancelar', '#5497d6' ,'#d33333'
        );
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/return_requests/updateEgresos/${return_request_id}`,
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
    })

    window.getAddDispersionVoucherFileModal = (return_request_return_type_id) => {
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/return_requests/getAddDispersionVoucherFileModal/${return_request_return_type_id}`,
            method: 'GET',
            success: function(response) {
                $('#addDispersionVoucherModal .modal-body').html(response);
                $('#addDispersionVoucherModal').modal('show');
            }
        });
    }
   

    $("#dispersionVoucherModal").on("submit", function(e) {
        e.preventDefault();
        const return_request_return_type_id = $("#return_request_return_type_id").val()

        if (this.checkValidity()) {
            const formData = new FormData($("#dispersionVoucherModal")[0]);
			const account_id = $('#account_id').val();
			formData.append('account_id', account_id);

            $.ajax({
                url: $('meta[name="app-url"]').attr('content')+`/return_requests/addDispersionVoucherFile/${return_request_return_type_id}`,
                type: "POST",
                data: formData,
                contentType: false, 
                processData: false, 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    console.log(response);
					if (response.status) {
						//Cerrar el modal y actualizar el datatable
						let dt = window.LaravelDataTables['return_request_return_types-table'];
						dt.draw(false)
						$('#addDispersionVoucherModal').modal('hide');
						$("#total_returned_text").text(formatNumber(response.data.total_returned))
						$("#total_rest_text").text(formatNumber(response.data.total_return - response.data.total_returned))
						$("#total_rest").val(response.data.total_sum_return_type - response.data.total_returned)
						$("#account_id").trigger("change")
						snackBar(response.message, "success")
					}else{
						snackBar(response.message, "danger")
					}
                },error: function(xhr, textStatus, errorThrown) {
                    errorMessage(xhr.status, errorThrown)
                }
            })
        };
    })

	$("#account_id").on("change", function(e){
        const account_id = $(this).val()

        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/accounts/getAccount/${account_id}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
				$("#account_info").html(response)
				console.log(response);
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        });

    })

})