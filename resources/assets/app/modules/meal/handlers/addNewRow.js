/**
 * Add next rows to the meal config grid
 *
 * @returns {boolean}
 */
export function addNewRow() {
    const add_counter = $('.add-counter').val();
    const tbody = $('#meal > tbody');
    const trLast = $('#meal_template').html();
    const lastID = tbody.find("tr").last().find('.meal_id').text();
    const incrementId = (parseInt(lastID) + 1) || 1;

    for (let i = 0; i < add_counter; i++) {
        tbody.append(trLast.replace(/%meal%/g, i + incrementId));
        tbody.find('.select2').select2();
    }

    return false;
}
