import http from "components/http/RequestBuilder";
import errorHandler from "components/http/errorHandler";
import successHandler from "components/http/successHandler";
import notifyError from "components/notify/notifyError";

/**
 * Send Gift
 *
 * @returns {boolean}
 */
export function sendCert () {
    const container = $('#cert-save-container');
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
                    let trophy_cups_count = $('#cert_cups_count');
                    trophy_cups_count.text(parseInt(trophy_cups_count.text()) + 1);
                    $('.table').hide();
                    $('#cert-save-container').find('input[type="text"], textarea').val('');
                }
            })
            .send();
    }

    return false;
}
