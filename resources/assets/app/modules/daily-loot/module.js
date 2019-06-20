import {saveState} from "./handlers/saveState";
import {addNewRow} from "./handlers/addNewRow";

import "./style.scss";


$(document)

    /**
     * Add next rows to the magic grid
     */
    .on('click', '.add-new-row', addNewRow)

    /**
     * Save the row
     */
    .on('click', '.update-row', saveState)

    /**
     * Mark the row as changed
     */
    .on('input', 'input', function () {
        $(this).closest('tr').addClass('changed')
    })

    /**
     * Mark the row as changed
     */
    .on('click', '.remove-embed', function () {
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
     * Switch page type
     */
    .on('click', '.toggle-page-type', function () {
        location.href = location.pathname.slice(0, location.pathname.lastIndexOf('/')) + $(this).data('href')
    })

    /**
     * How many rows to add
     * Change counter
     */
    .on('input', '.add-counter', function () {
        $('.add-counter').val(this.value)
    });
