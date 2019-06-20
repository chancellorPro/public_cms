import Dropzone from 'dropzone';
import dropzoneInit from "./handlers/dropzoneInit";
import observer from "components/observer/EventObserver";
import awardCreate from "listeners/awardCreate";
import awardDelete from "listeners/awardDelete";
import {AWARD_CREATE, AWARD_DELETE} from "modules/award/constants";

/**
 * Turned off the Dropzone auto init
 *
 * @type {boolean}
 */
Dropzone.autoDiscover = false;

/**
 * Dropzone init
 */
$('.dropzone').each(dropzoneInit);

$(document)

    /**
     * Create award and save row
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