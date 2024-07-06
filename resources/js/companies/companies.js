$(document).ready(function(){
    $.ajax({
        url: $('meta[name="app-url"]').attr('content')+`/accounts/getDataAutocomplete`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            autocomplete("account", response, "Buscar...")
        },error: function(xhr, textStatus, errorThrown) {
            errorMessage(xhr.status, errorThrown)
        }
    });
    
    //Funcion que agrega una cuenta a una compañía
    window.addAccount = () => {
        //Valida que el account_id exista
        const account_id = $("#account_id").val()
        //Obtiene todos los ids de las cuentas ya agregadas
        const existAccountId = $("#accountsContainer").find(".account_id").filter(function() {
            return $(this).val() === account_id;
        }).length > 0; 

        if (account_id == "") {
            snackBar("No se ha seleccionado una cuenta válida", "warning")
            return false
        }
        if (existAccountId) {
            snackBar("La cuenta seleccionada ya existe para esta empresa", "warning")
            return false
        }

        getAccountById(account_id)
        .then(response => {
            let newElement = $(response).hide();
            $("#accountsContainer").append(newElement);
            newElement.fadeIn();
            $("#account_name").val("")
            $("#account_id").val("")
        })
        .catch(error => {
            console.log(error);
        });
    }

    window.deleteAccount = (element) => {
        $(element).closest(".account").fadeOut(400, function() {
            $(this).remove();
        });
    }

    function getAccountById(account_id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: $('meta[name="app-url"]').attr('content') + `/companies/addAccount/${account_id}`,
                type: 'GET',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    resolve(response);
                },
                error: function(xhr, textStatus, errorThrown) {
                    errorMessage(xhr.status, errorThrown);
                    reject(new Error(`Error ${xhr.status}: ${errorThrown}`));
                }
            });
        });
    }
})