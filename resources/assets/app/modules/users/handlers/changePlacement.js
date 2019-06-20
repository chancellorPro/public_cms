/**
 * Change placement select in Add Assets block
 */
export default function () {
    const placementName = $('#placement-name');
    if ($(this).val() > 0) {
        placementName.attr('disabled', 'disabled');
    } else {
        placementName.removeAttr('disabled');
    }
}
