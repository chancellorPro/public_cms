import http from "components/http/RequestBuilder";
import {SavedItemNotFound} from "exceptions/SavedItemNotFound";
import getFormData from "helpers/getFormData";

export default function (e) {
    e.preventDefault();

    const currentBtn = $(this);
    const savedItem = currentBtn.closest('.fast-save-container');

    if (!savedItem.length) {
        throw new SavedItemNotFound;
    }

    new http(currentBtn.attr('href'))
        .method('PUT')
        .data(getFormData(savedItem))
        .send();

    return false;
}
