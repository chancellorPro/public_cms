import {changeTab} from "./handlers/changeTab";
import {addNewRow} from "./handlers/addNewRow";
import {saveState} from "./handlers/saveState";

$(document)

    /**
     * Add next rows to the grid
     */
    .on('click', '.add-new-row', addNewRow)

    /**
     * Change url on tab change
     */
    .on('click', '.nav-link', changeTab)

    /**
     * Mark the row as changed
     */
    .on('input', 'input', function () {
        $(this).closest('tr').addClass('changed')
    })

    /**
     * Remove empty row
     */
    .on('click', '.delete-row', function () {
        $(this).closest('tr').remove();
    })

    /**
     * How many rows to add
     * Change counter
     */
    .on('input', '.add-counter', function () {
        $('.add-counter').val(this.value)
    })

    /**
     * Save state
     */
    .on('click', '.save-page', saveState);

