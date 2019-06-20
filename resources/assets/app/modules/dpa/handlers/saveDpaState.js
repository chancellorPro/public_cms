import http from "components/http/RequestBuilder";

/**
 * Update row to the dpa config grid
 *
 * @returns {boolean}
 */
export function saveDpaState (e) {
    e.preventDefault();

    let route = $(this).data('route');
    let data = $('.dpa-save-page-container').find(".changed input, .changed select").serializeArray();

    new http(route)
        .method('PUT')
        .data(data)
        .send();

    return false;
}
