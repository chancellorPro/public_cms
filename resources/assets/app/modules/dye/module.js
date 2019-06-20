import {addNewRow} from "./handlers/addNewRow";
import {changeRowIndex} from "./handlers/changeRowIndex";
import dyeSavePage, {DYE_CONTAINER_SELECTOR, markChangedTr} from "./handlers/dyeSavePage";

$(document)

    /**
     * Init color-picker inputs
     */
    .ready(function() {
        $('.cp2').colorpicker()
            .on('create', function (e) {
                $(document)
                    /**
                     * Mark tr as changed
                     */
                    .on('change', `${DYE_CONTAINER_SELECTOR} input, ${DYE_CONTAINER_SELECTOR} select, ${DYE_CONTAINER_SELECTOR} textarea`, markChangedTr)
                    .on('input', `${DYE_CONTAINER_SELECTOR} input, ${DYE_CONTAINER_SELECTOR} select, ${DYE_CONTAINER_SELECTOR} textarea`, markChangedTr);
        });
    })

    /**
     * Add next rows to the dye grid
     */
    .on('click', '.add-new-row', addNewRow)

    /**
     * Remove empty row
     */
    .on('click', '.delete-row', function () {
        $(this).closest('tr').remove()
    })

    /**
     * Change row index
     */
    .on('input', '.asset_id', changeRowIndex)

    /**
     * How many rows to add
     * Change counter
     */
    .on('input', '.add-counter', function () {
        $('.add-counter').val(this.value)
    });

    /**
     * Fast save data on the dyes page
     */
    $('.dye-save-page').click(dyeSavePage);
