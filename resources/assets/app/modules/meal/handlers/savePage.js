import http from "components/http/RequestBuilder";
import notifyError from "components/notify/notifyError";

/**
 * Update row to the Meal config grid
 *
 * @returns {boolean}
 */
export function saveMealState () {
    const route = $(this).data('route');
    const tbody = $('.meal-save-page-container').find(".changed");
    const data = $('.meal-save-page-container').find(".changed input, .changed select").serializeArray();

    if(data.length === 0) {
        return false;
    }

    new http(route)
        .method('PUT')
        .data(data)
        .send();

    tbody.each(function (n, item) {
        $(item).removeClass('changed');
    });

    return false;
}
