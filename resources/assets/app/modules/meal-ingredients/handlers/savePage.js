import http from "components/http/RequestBuilder";

/**
 * Update row to the Meal Ingredients config grid
 *
 * @returns {boolean}
 */
export function saveMealIngredientsState () {
    let route = $(this).data('route');
    let data = $('.meal-ingredients-save-page-container').find(".changed input");

    new http(route)
        .method('PUT')
        .data(data)
        .send();

    return false;
}
