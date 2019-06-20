/**
 * Hide assets in placement
 */
export default function (e) {
    e.preventDefault();

    const currentElement = $(this);
    currentElement.toggleClass('hide');
    currentElement.siblings('.load-assets').toggleClass('hide');
    $('#asset-container-' + currentElement.data('placement')).html('');

    return false;
}
