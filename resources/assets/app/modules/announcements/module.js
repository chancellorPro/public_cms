import {addNewRow} from "./handlers/addNewRow";
import {saveState} from "./handlers/saveState";
import {AWARD_CREATE, AWARD_DELETE} from "modules/award/constants";
import observer from "components/observer/EventObserver";
import awardDelete from "listeners/awardDelete";
import awardCreate from "listeners/awardCreate";

$(document)

    /**
     * Add next rows to the announcements grid
     */
    .on('click', '.add-new-row', addNewRow)

    /**
     * Mark row as changed
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
     * Mark row as changed for select2
     */
    .on('input', ':checkbox', function () {
        $(this).attr("checked", !$(this).attr("checked"));
    })

    /**
     * Remove empty row
     */
    .on('click', '.delete-row', function () {
        $(this).closest('tr').remove();
    })

    /**
     * Create award and save announcement
     */
    .on('click', '.award-create-button', function () {
        const _this = this;
        awardCreate.bind(_this)();
        $(this).closest('tr').addClass('award-changed');

        observer.subscribe(AWARD_CREATE, (data, self) => {
            saveState('award-')
        });
    })

    /**
     * Delete award
     */
    .on('click', '.award-delete-button', function () {
        const _this = this;
        const saveButton = $('.save-page');

        $(this).closest('tr').addClass('award-changed');
        $(this).closest('tr').find('input[name="award_id"]').val(0);

        awardDelete.bind(_this, saveButton)();
        observer.subscribe(AWARD_DELETE, (data, self) => {
            saveState('award-')
        });
    })

    /**
     * How many rows to add
     * Change counter
     */
    .on('input', '.add-counter', function () {
        $('.add-counter').val(this.value)
    });

    /**
     * Fast save data on the announcements page
     */
    $('.save-page').click(() => saveState());
