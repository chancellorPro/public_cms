import {saveSoundState} from "./handlers/saveSoundState";
import {addNewRow} from "./handlers/addNewRow";

$(document)

    /**
     * Add next rows to the sound grid
     */
    .on('click', '.add-new-row', addNewRow)

    /**
     * Save the row
     */
    .on('click', '.update-row', saveSoundState)

    /**
     * Mark the row as changed
     */
    .on('input', 'input', function () {
        $(this).closest('tr').addClass('changed')
    })

    /**
     * Mark row as changed
     */
    .on('.select2').change(function (item) {
        $(item.target).closest('tr').addClass('changed');
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
