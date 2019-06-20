import {savePage} from "./handlers/savePage";
import {changeTab} from "modules/cms-roles/handlers/changeTab";

$(document)

    /**
     * Change url on tab change
     */
    .on('click', '.deploy-tabs .nav-link', changeTab)

    /**
     * Mark row as changed
     */
    .on('.select2').change(function (item) {
        $(item.target).closest('tr').addClass('changed');
    });

/**
 * Fast save data
 */
$('.save-page').click(savePage);
