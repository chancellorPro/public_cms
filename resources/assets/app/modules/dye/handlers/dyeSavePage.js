import http from "components/http/RequestBuilder";
import {SavedItemNotFound} from "exceptions/SavedItemNotFound";
import getFormData from "helpers/getFormData";
import successHandler from "components/http/successHandler";

export const DYE_CONTAINER_SELECTOR = '.dye-save-page-container';

/**
 * Fast save data from the dyes page
 *
 * @param e
 *
 * @returns {boolean}
 */
export default function (e) {
    e.preventDefault();

    const currentBtn = $(this);
    const savedItem = $(DYE_CONTAINER_SELECTOR);

    if (!savedItem.length) {
        throw new SavedItemNotFound;
    }

    if (savedItem.hasClass('progress')) {
        return false;
    }
    savedItem.addClass('progress');

    /**
     * Get changed data
     */
    const formItems = savedItem.find('.changed');
    const data = getFormData(formItems);

    if (!Object.keys(data).length) {
        savedItem.removeClass('progress');
        return false;
    }

    new http(currentBtn.attr('href'))
        .method('PUT')
        .data(data)
        .complete(() => {
            savedItem.removeClass('progress');
        })
        .success(response => {
            formItems.removeClass('changed');
            successHandler(response);
        })
        .send();

    return false;
}

/**
 * Mark form's tr as changed
 */
export function markChangedTr() {
    $(this).closest('tr').addClass('changed');
}
