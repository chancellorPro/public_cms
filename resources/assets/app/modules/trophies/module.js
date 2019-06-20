import {sendGift} from "./handlers/sendGift";
import {findUser} from "./handlers/findUser";

$(document)

    /**
     * Find user
     */
    .on('click', '#find_sender, #find_receiver', findUser)

    /**
     * Save the row
     */
    .on('click', '#send', sendGift)

    /**
     * Mark selected row
     */
    .on('click', '.table tr', function () {
        $(this).find('input[type="radio"]').prop("checked", true);
        $('#' + $(this).data('target') + '_uid').val($(this).data('uid'))
    })

    /**
     * Change limit counter
     */
    .on('input', 'textarea', function () {
        const target = $(this).prop('name').replace('cup_data[', '').replace(']', '') + '_length';
        $('#' + target).text($(this).data('maxlength') - $(this).val().length);
    })

    /**
     * Remove entered data
     */
    .on('click', '#cancel', function () {
        $('.table').hide();
        $(this).closest('table').find('input[type="text"], textarea').val('')
    });
