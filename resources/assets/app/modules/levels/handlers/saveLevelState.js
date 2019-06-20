import http from "components/http/RequestBuilder";

/**
 * Update row to the levels config grid
 *
 * @returns {boolean}
 */
export function saveLevelState () {
    let rowToSave = $(this).parents('tr');
    let row = rowToSave.find(".editable select, .editable input").serializeArray();

    new http(rowToSave.data('action'))
        .method('PUT')
        .data(row)
        .send();
}
