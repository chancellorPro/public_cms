import ModalBuilder from "components/modal/ModalBuilder";
import {SIZES} from "components/bootstrap/constants";
import observer from "components/observer/EventObserver";
import http from "components/http/RequestBuilder";

/**
 * Open modal with form by request
 */
export default function(e) {
    e.preventDefault();

    const currentButton = $(this);

    if (currentButton.hasClass('loading')) {
        return false;
    }
    currentButton.addClass('loading');

    new http(this.href)
        .method(this.dataset.method || 'get')
        .success(response => {
            new ModalBuilder()
                .size(SIZES.lg)
                .dataset({
                    reload: this.dataset.reload || 1,
                })
                .header(this.dataset.header)
                .afterBuild(() => {
                    if (!!this.dataset.event) {
                        observer.dispatch(this.dataset.event, response);
                    }
                })
                .modal(response);
        })
        .complete(() => {
            currentButton.removeClass('loading');
        })
        .send();

    return false;
}
