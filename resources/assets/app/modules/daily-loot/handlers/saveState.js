import http from "components/http/RequestBuilder";
import notifyError from "components/notify/notifyError";
import successHandler from "components/http/successHandler";

/**
 * Update row to the sound config grid
 *
 * @returns {boolean}
 */
export function saveState () {
    const container = $('.daily-loot-save-container');
    const data = container.find(".changed input, .changed select").serializeArray();

    if(!data.length) {
        notifyError('Nothing to save!');

        return false;
    }

    new http($(this).data('route'))
            .method('PUT')
            .data(data)
            .success(function (resp) {
                container.find('tr.changed').removeClass('changed');
                successHandler(resp);
            })
            .send();

    return false;
}
