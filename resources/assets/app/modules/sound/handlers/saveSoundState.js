import http from "components/http/RequestBuilder";

/**
 * Update row to the sound config grid
 *
 * @returns {boolean}
 */
export function saveSoundState () {
    const data = $('.sound-save-container').find(".changed input, .changed select").serializeArray();

    if(data.length) {
        new http($(this).data('route'))
            .method('PUT')
            .data(data)
            .send();
    }

    return false;
}
