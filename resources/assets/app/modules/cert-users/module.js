import {saveState} from "./handlers/saveState";
import {changeTab} from "modules/cms-roles/handlers/changeTab";

$(document)

/**
 * Save the row
 */
    .on('click', '.update-row', saveState)

    /**
     * Change url on tab change
     */
    .on('click', '.deploy-tabs .nav-link', changeTab)

    /**
     * Mark the row as changed
     */
    .on('input', 'input', function () {
        $(this).closest('tr').addClass('changed')
    });
