/**
 * Collapse state
 *
 * @param e
 *
 * @returns {boolean}
 */
export default function (e) {
    e.preventDefault();

    const parent = $(this).closest('.action-type-state');
    parent.toggleClass('down');

    return false;
}
