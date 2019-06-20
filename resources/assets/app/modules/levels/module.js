import {saveLevelState} from "./handlers/saveLevelState";
import {addNewRow} from "./handlers/addNewRow";
import awardCreate from "listeners/awardCreate";
import awardDelete from "listeners/awardDelete";
import observer from "components/observer/EventObserver";
import {AWARD_CREATE, AWARD_DELETE} from "modules/award/constants";

$(document)

    /**
     * Create award and save level
     */
    .on('click', '.award-create-button', function () {
        const _this = this;
        const saveButton = $(this).closest('tr').find('.update-row');

        awardCreate.bind(_this)();

        observer.subscribe(AWARD_CREATE, (data, self) => {
            saveButton.click();
        });
    })

    /**
     * Delete award
     */
    .on('click', '.award-delete-button', function () {
        const _this = this;
        const saveButton = $(this).closest('tr').find('.update-row');

        awardDelete.bind(_this, saveButton)();

        observer.subscribe(AWARD_DELETE, (data, self) => {
            saveButton.click();
        });
    })

    /**
     * Add next rows to the levels grid
     */
    .on('click', '.add-new-row', addNewRow)

    /**
     * Save the row
     */
    .on('click', '.update-row', saveLevelState)

    /**
     * How many rows to add
     * Change counter
     */
    .on('input', '.add-counter', function () {
        $('.add-counter').val(this.value)
    });
