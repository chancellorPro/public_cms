import {sendCert} from "./handlers/sendCert";
import {findUser} from "./handlers/findUser";
import {changeTab} from "modules/cms-roles/handlers/changeTab";

$(document)

/**
 * Find user
 */
    .on('click', '#find_sender, #find_receiver', findUser)

    /**
     * Save the row
     */
    .on('click', '#send', sendCert)

    /**
     * Mark selected cert
     */
    .on('click', '#assets_list img', function () {
        $('#assets_list').find('img').css('border', '');
        $(this).css('border', '3px solid #5c5c5c');
        $('#asset_id').val($(this).data('cert'));
    })

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
    .on('input', 'input, textarea', function () {
        const target = $(this).prop('name').replace('cert_data[', '').replace(']', '') + '_length';
        $('#' + target).text($(this).data('maxlength') - $(this).val().length);
    })
    
    /**
     * Remove entered data
     */
    .on('click', '#cancel', function () {
        $('.table').hide();
        $(this).closest('table').find('input[type="text"], textarea').val('')
    });
