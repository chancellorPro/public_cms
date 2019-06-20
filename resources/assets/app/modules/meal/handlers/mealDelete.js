/**
 * Hide row
 *
 * @returns {boolean}
 */
export function mealDelete() {
    $(this).closest('tr').remove();

    return false;
}
