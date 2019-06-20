/**
 * Change mode for add neighbors
 */
export default function () {
    const neighborsCount = $('#neighbors-count');
    if($(this).is(':checked')) {
        neighborsCount.removeAttr('disabled');
    } else {
        neighborsCount.attr('disabled', 'disabled');
    }
}
