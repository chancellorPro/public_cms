import http from "components/http/RequestBuilder";
import notifyError from "components/notify/notifyError";
import successHandler from "components/http/successHandler";

/**
 * Store User
 *
 * @returns {boolean}
 */
export function adminStore() {
    const selected_id = $('#sender_list').find('[name="user_sender"]:checked').closest('tr').data('uid');

    if (!selected_id) {
        notifyError('Nothing to find!');
    } else {
        new http($(this).data('route'))
            .method('POST')
            .data({uid: selected_id})
            .success(response => {
                successHandler(response);
                location.reload();
            })
            .send();
    }
}
