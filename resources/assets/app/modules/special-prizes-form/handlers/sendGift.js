import http from "components/http/RequestBuilder";
import errorHandler from "components/http/errorHandler";
import successHandler from "components/http/successHandler";
import notifyError from "components/notify/notifyError";

/**
 * Send Gift
 *
 * @returns {boolean}
 */
export function sendGift () {
    const container = $('#send-container');
    const formItems = container.find("input, textarea").serializeArray();

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
                    successHandler(response);
                    $('.table').hide();
                }
            })
            .send();
    }

    return false;
}
