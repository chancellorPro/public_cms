/**
 * Hide row
 *
 * @returns {boolean}
 */
export function ingredientDelete() {
    $(this).closest('tr').remove();

    return false;
}
