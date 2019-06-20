import {changeTab} from "./handlers/changeTab";
import {findUser} from "modules/group-edit/handlers/findUser";
import {adminStore} from "modules/group-edit/handlers/adminStore";
import {setMain} from "modules/group-edit/handlers/setMain";

$(document)

    /**
     * Find user
     */
    .on('click', '#find_sender, #find_receiver', findUser)

    /**
     * Mark selected row
     */
    .on('click', '.table tr', function () {
        $(this).find('input[type="radio"]').prop("checked", true);
        $('#sender_uid').val($(this).data('uid'))
    })

    /**
     * Store user to group
     */
    .on('click', '#store', adminStore)

    /**
     * Change main admin
     */
    .on('click', '.update-row', setMain)

    /**
     * Change url on tab change
     */
    .on('click', '.deploy-tabs .nav-link', changeTab);

