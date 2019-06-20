import http from "components/http/RequestBuilder";

/**
 * PLACEMENT_ASSETS_ROUTE - it is a global object
 * Inited in user/edit.blade.php
 */
export default function (e) {
    e.preventDefault();

    const currentElement = $(this);
    let placement = currentElement.data('placement');

    currentElement.toggleClass('hide');
    currentElement.siblings('.hide-assets').toggleClass('hide');

    loadPart(PLACEMENT_ASSETS_ROUTE + '?placement=' + placement, $('#asset-container-' + placement));

    return false;
}

/**
 * Load part for edit user page
 */
function loadPart(action, element) {
    new http(action)
        .method('get')
        .success(response => {
            const items = $(response);
            items.find('.list-thumbnail').popover({
                container: 'body',
                html: true,
                trigger: 'hover',
                placement: 'right',
                content: function () {
                    return '<img src="' + $(this).data('full') + '">';
                }
            });
            element.replaceWith(items);
        })
        .send();
}