import {SIZES} from "components/bootstrap/constants";
import ModalBuilder from "components/modal/ModalBuilder";

/**
 * Modal confirm
 *
 * @param message
 * @param callback
 */
export function modalConfirm(message, callback) {
    new ModalBuilder()
        .size(SIZES.sm)
        .header(message)
        .footer($('<button/>', {
            'class': 'btn btn-sm btn-success',
            'text': 'Confirm',
            'data-dismiss': 'modal',
            'click': callback
        }))
        .modal();
}
