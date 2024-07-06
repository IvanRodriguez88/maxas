$(document).ready(function(){
    $('#openModal').click(function() {
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/promotors/getAddPromotorClientModal`,
            method: 'GET',
            success: function(response) {
                $('#addPromotorClientModal .modal-body').html(response);
                $('#addPromotorClientModal').modal('show');
            }
        });
    });
});