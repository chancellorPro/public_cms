import http from "components/http/RequestBuilder";
import notifyError from "components/notify/notifyError";
import successHandler from "components/http/successHandler";

/**
 * Change main admin
 *
 * @returns {boolean}
 */
export function setMain(e) {
    e.preventDefault();
    const is_main = $('#group-users').find('input[type="radio"]:checked').data('id');

    if (!is_main) {
        notifyError('Nothing to save!');
    } else {
        new http($(this).data('route'))
            .method('PUT')
            .data({main_id: is_main})
            .success(response => {
                successHandler(response);
            })
            .send();
    }
}
