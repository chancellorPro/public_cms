/**
 * Remove not saved row
 *
 * @returns {boolean}
 */
export function removeRow(e) {
    e.preventDefault();

    $(this).parents('tr').remove();

    return false;
}
