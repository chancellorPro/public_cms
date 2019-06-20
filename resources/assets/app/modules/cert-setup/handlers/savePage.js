import http from "components/http/RequestBuilder";
import errorHandler from "components/http/errorHandler";
import successHandler from "components/http/successHandler";
import notifyError from "components/notify/notifyError";

/**
 * Save
 *
 * @returns {boolean}
 */
export function savePage () {
    const container = $('#cert-save-container');
    const formItems = container.find(".changed select").serializeArray();
    const rows = container.find(".changed");

    if(!formItems.length) {
        notifyError('Nothing to send!');
    } else {
        new http($(this).data('route'))
            .method('POST')
            .data(formItems)
            .success(response => {
                if(!!response.errors){
                    errorHandler(response);
                } else {
                    rows.removeClass('changed');
                    successHandler(response);
                }
            })
            .send();
    }

    return false;
}
