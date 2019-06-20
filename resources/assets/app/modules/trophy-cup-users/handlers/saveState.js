import http from "components/http/RequestBuilder";
import successHandler from "components/http/successHandler";
import notifyError from "components/notify/notifyError";

/**
 * Update row to the magic config grid
 *
 * @returns {boolean}
 */
export function saveState () {
    const container = $('.trophy-save-container');
    const data = container.find(".changed input");
    const formItems = container.find(".changed");

    if(!data.length) {
        notifyError('Nothing to save!');
    } else {
        new http($(this).data('route'))
            .method('PUT')
            .data(data)
            .success(response => {
                formItems.removeClass('changed');
                successHandler(response);
            })
            .send();
    }

    return false;
}
