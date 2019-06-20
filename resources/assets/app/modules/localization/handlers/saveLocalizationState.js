import http from "components/http/RequestBuilder";
import successHandler from "components/http/successHandler";
import errorHandler from "components/http/errorHandler";

/**
 * Update row to the localization config grid
 *
 * @returns {boolean}
 */
export function saveLocalizationState (e) {
    e.preventDefault();

    const currentBtn = $(this);
    const parent = currentBtn.closest('tr');
    const currentKey = parent.find('.localization-key').val();

    /**
     * Check duplicated keys
     *
     * @type {jQuery}
     */
    const currentKeyDuplicate = $('#localizations').find('.localization-key').filter((_, item) => {
        return currentKey === item.value;
    });
    if (currentKeyDuplicate.length > 1){
        errorHandler({'message': 'Duplicate key ' + currentKey});
        return false;
    }

    const data = parent.find('.editable input').serializeArray();

    new http(currentBtn.attr('href'))
        .method('PUT')
        .data(data)
        .success(response => {
            parent.find('.localization-key').attr('readonly', true);

            successHandler(response);
        })
        .send();

    return false;
}
