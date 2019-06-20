import {SIZES} from "components/bootstrap/constants";
import ModalBuilder from "components/modal/ModalBuilder";
import RequestBuilder from "components/http/RequestBuilder";
import observer from "components/observer/EventObserver";
import {ACTION_TYPE_STATES_CHANGED} from "modules/action-type/constants";

/**
 * Remove the State of the Action Type
 * at the modal
 * with confirm
 */
export default function () {
    const currentElement = $(this);
    const parent = currentElement.closest('.action-type-state');

    if (!currentElement.data('id')) {
        parent.remove();
        observer.dispatch(ACTION_TYPE_STATES_CHANGED, {});
        return false;
    }

    new ModalBuilder()
        .size(SIZES.sm)
        .header('Are you sure?')
        .footer($('<button/>', {
            'class': 'btn btn-sm btn-danger',
            'text': 'Delete',
            'data-dismiss': 'modal',
            'click': () => {
                new RequestBuilder(currentElement.data('url'))
                    .method('DELETE')
                    .success(() => {
                        parent.remove();
                        observer.dispatch(ACTION_TYPE_STATES_CHANGED, {});
                    })
                    .send();
            }
        }))
        .modal();

    return false;
}
