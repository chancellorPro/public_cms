$(document).ready(function () {
    var chengedRowsCount = 0;

    $('.editable input').change(function () {
        $(this).parents('tr').find('.for-update').iCheck('check');
    })

    $('.for-update').on('ifChecked', function (event) {
        chengedRowsCount++;
        enableSave();
    });

    $('.for-update').on('ifUnchecked', function (event) {
        chengedRowsCount--;
        enableSave();
    });

    function enableSave() {
        if (chengedRowsCount > 0) {
            $('#update-all').removeClass('disabled');
        } else {
            $('#update-all').addClass('disabled');
        }
    }
    
    $('#update-all').click(function (e) {
        e.preventDefault();
        $.each($(".for-update:checked"), function () {
            let rowToSave = $(this).parents('tr');
            saveRow(rowToSave);
        });
    });

    $('.update-row').click(function (e) {
        let rowToSave = $(this).parents('tr');
        saveRow(rowToSave);
    });

    function saveRow(rowToSave) {
        let id = rowToSave.data('id');
        let action = rowToSave.data('action');
        var row = rowToSave.find(".editable select, .editable input").serializeArray();

        $.ajax({
            type: "PUT",
            dataType: 'json',
            url: action,
            data: row,
            success: function (resp) {
                $.notify({
                    message: resp.msg
                }, {
                    type: resp.type
                });
            },
            error: function (jqXHR, exception) {
                if (jqXHR.responseJSON.hasOwnProperty('errors')) {
                    $.each(jqXHR.responseJSON.errors, function (errorKey, error) {
                        $.each(error, function (messageKey, message) {
                            $.notify({
                                message: message
                            }, {
                                type: 'danger'
                            });
                        });
                    });
                }
            }
        });
    }
})