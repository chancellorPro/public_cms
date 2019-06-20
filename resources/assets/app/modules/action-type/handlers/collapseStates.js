/**
 * Collapse states
 *
 * @param e
 *
 * @returns {boolean}
 */
export default function (e) {
    e.preventDefault();

    $('.action-type-state').toggleClass('down');

    return false;
}
