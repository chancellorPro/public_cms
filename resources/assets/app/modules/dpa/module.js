import {addNewRow} from "./handlers/addNewRow";
import {saveDpaState} from "./handlers/saveDpaState";

$(document)

    /**
     * Delete dpa
     */
    .on('click', '.delete-row', function () {
        $(this).closest('tr').remove();
    })

    /**
     * Add next row to the dpa grid
     */
    .on('click', '.add-new-row', addNewRow)

    /**
     * Add next row to the dpa grid
     */
    .on('input', 'input', function () {
        $(this).closest('tr').addClass('changed');
    })

    /**
     * Mark row as changed
     */
    .on('.select2').change(function (item) {
        $(item.target).closest('tr').addClass('changed');
    })

    /**
     * Fast save data on the dyes page
     */
    .on('click', '.dpa-save-page', saveDpaState)

    /**
     * How many rows to add
     * Change counter
     */
    .on('input', '.add-counter', function () {
        $('.add-counter').val(this.value)
    });
