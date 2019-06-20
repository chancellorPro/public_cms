import {saveState} from "./handlers/saveState";
import {changeTab} from "./handlers/changeTab";

$(document)

    /**
     * Change url on tab change
     */
    .on('click', '.deploy-tabs .nav-link', changeTab)

    /**
     * Save the row
     */
    .on('click', '.update-row', saveState)

    /**
     * Mark the row as changed
     */
    .on('input', 'input', function () {
        $(this).closest('tr').addClass('changed')
    });
