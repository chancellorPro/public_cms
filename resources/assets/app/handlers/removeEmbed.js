import {SIZES} from "components/bootstrap/constants";
import ModalBuilder from "components/modal/ModalBuilder";

/**
 * Remove embeded element
 */
export default function (e) {
    e.preventDefault();

    const parent = !!this.dataset.parent ? $(this).closest(this.dataset.parent) : $(this).parent();

    if (!this.dataset.id) {
        parent.remove();
        return;
    }

    new ModalBuilder()
        .size(SIZES.sm)
        .header('Are you sure?')
        .footer($('<button/>', {
            'class': 'btn btn-sm btn-danger',
            'text': 'Delete',
            'data-dismiss': 'modal',
            'click': () => {
                parent.remove()
            }
        }))
        .modal();

    return false;
}
