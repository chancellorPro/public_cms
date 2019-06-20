import http from "components/http/RequestBuilder";

/**
 * Update row to the magic config grid
 *
 * @returns {boolean}
 */
export function saveMagicState () {
    const data = $('.magic-save-container').find(".changed input");

    data.each(function (n, item) {
        $(item).attr('readonly', true)
    });

    if(data.length) {
        new http($(this).data('route'))
            .method('PUT')
            .data(data)
            .send();
    }

    return false;
}
