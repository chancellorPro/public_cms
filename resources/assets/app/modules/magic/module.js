import {saveMagicState} from "./handlers/saveMagicState";
import {addNewRow} from "./handlers/addNewRow";

$(document)

    /**
     * Add next rows to the magic grid
     */
    .on('click', '.add-new-row', addNewRow)

    /**
     * Save the row
     */
    .on('click', '.update-row', saveMagicState)

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
        $(this).closest('tr').remove()
    })

    /**
     * How many rows to add
     * Change counter
     */
    .on('input', '.add-counter', function () {
        $('.add-counter').val(this.value)
    });
