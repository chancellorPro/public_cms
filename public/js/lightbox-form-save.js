$('.lightbox-content form').on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: $(this).attr('method'),
        dataType: 'json',
        url: $(this).attr('action'),
        data: $(this).serializeArray(),
        success: function( resp ) {
            location.reload();
        },
        error: function (jqXHR, exception) {

            if (jqXHR.responseJSON.hasOwnProperty('errors')) {
                $.each( jqXHR.responseJSON.errors, function(errorKey, error ) {
                    $.each( error, function(messageKey, message ) {
                        $.notify({
                            message: message
                        },{
                            type: 'danger',
                            z_index: 1051
                        });
                    });
                });
            }
        }
    });
})

