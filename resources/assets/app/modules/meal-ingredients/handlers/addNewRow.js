/**
 * Add next rows to the ingredient config grid
 *
 * @returns {boolean}
 */
export function addNewRow() {
    const add_counter = $('.add-counter').val();
    const tbody = $('#meal_ingredients > tbody');
    const trLast = $('#meal_ingredients_template').html();

    let lastID = tbody.find("tr").last().find('.ingredient_id').text();
    let incrementId = (parseInt(lastID) + 1) || 1;

    for (let i = 0; i < add_counter; i++) {
        tbody.append(trLast.replace(/%meal-ingredient%/g, i + incrementId));
    }

    return false;
}
