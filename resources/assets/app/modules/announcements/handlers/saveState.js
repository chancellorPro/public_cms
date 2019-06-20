import http from "components/http/RequestBuilder";
import notifyError from "components/notify/notifyError";
import successHandler from "components/http/successHandler";

/**
 * Update row to the announcements config grid
 *
 * @returns {boolean}
 */
export function saveState (award = '') {
    const route = $(this).data('route');
    const container = $('.announcements-save-page-container');
    const data = container.find("." + award + "changed input, ." + award + "changed select").serializeArray();

    if(!data.length) {
        notifyError('Nothing to save!');

        return false;
    }

    new http(route)
        .method('PUT')
        .data(data)
        .success(function (resp) {
            container.find('tr.' + award + 'changed').removeClass(award + 'changed');
            successHandler(resp);
        })
        .send();

    return false;
}
