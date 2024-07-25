
$(document).ready(function(){
    
    if ($("#currency_type_id").val() == 2) {
        $("#dls-fields").removeClass("d-none")
        changeRequiredFields(true)
    }else{
        $("#dls-fields").addClass("d-none")
        changeRequiredFields(false)
    }

    $("#currency_type_id").on("change", function() {
        const currency_type_id = $(this).val()
        if (currency_type_id == 2) {
            $("#dls-fields").removeClass("d-none")
            changeRequiredFields(true)
        }else{
            $("#dls-fields").addClass("d-none")
            changeRequiredFields(false)

        }
    })

    function changeRequiredFields(value){
        $("#ava").attr("required", value)
        $("#swift").attr("required", value)
    }

    $("#accounts-form").on("submit", function(e) {
        e.preventDefault();

        const account_number = $("#account_number").val()
        const clabe = $("#clabe").val()


        if (this.checkValidity()) {
            console.log(1);
            if (account_number == "" && clabe == "") {
                snackBar("Se requiere agregar el número de cuenta o clabe", "warning")
            }else{
                this.submit()
            }
        }

    })

})