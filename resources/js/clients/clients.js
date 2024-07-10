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
})