import ModalBuilder from "components/modal/ModalBuilder";
import {SIZES} from "components/bootstrap/constants";
import observer from "components/observer/EventObserver";
import http from "components/http/RequestBuilder";
import successHandler from "components/http/successHandler";

/**
 * Open confirm modal before action
 */
export default function(e) {
    e.preventDefault();

    const dataSet = this.dataset;
    const url = this.href;

    new ModalBuilder()
        .size(SIZES.sm)
        .header(dataSet.header)
        .footer(
            $('<button/>', {
                'class': (dataSet.btnClass || 'btn-sm btn-success') + ' btn',
                'text': dataSet.btnName || 'Confirm',
                'click': function () {
                    const currentButton = $(this);

                    if (currentButton.hasClass('loading')) {
                        return false;
                    }
                    currentButton.addClass('loading');

                    new http(url)
                        .method(dataSet.method || 'get')
                        .success(response => {
                            if (!!dataSet.event) {
                                observer.dispatch(dataSet.event, response);
                            }

                            if (parseInt(dataSet.reload) === 1) {
                                location.reload();
                            }

                            if (parseInt(dataSet.dismiss) === 1) {
                                currentButton.closest('.modal').modal('hide');
                            }

                            successHandler(response);
                        })
                        .complete(() => {
                            currentButton.removeClass('loading');
                        })
                        .send();
                }
            })
        )
        .modal();

    return false;
}
