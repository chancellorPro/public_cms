import http from "components/http/RequestBuilder";
import {SavedItemNotFound} from "exceptions/SavedItemNotFound";
import getFormData from "helpers/getFormData";

/**
 * Fast save for shop department
 *
 * @param e
 *
 * @returns {boolean}
 */
export default function (e) {
    e.preventDefault();

    const dataNamePrefix = 'shop';
    const currentBtn = $(this);
    const fastSaveContainer = currentBtn.closest('.fast-save-container');

    if (!fastSaveContainer.length) {
        throw new SavedItemNotFound;
    }

    let result = {};
    fastSaveContainer.find('tbody tr').each(function (index) {
        let formData = getFormData($(this));
        for (let i in formData) {
            const itemName = `${dataNamePrefix}[${index}][${i}]`;
            result[itemName] = formData[i];
        }
    });

    new http(currentBtn.attr('href'))
        .method('PUT')
        .data(result)
        .send();

    return false;
}
