/**
 * Add next rows to the levels config grid
 *
 * @returns {boolean}
 */
export function addNewRow() {
    let add_counter = $('.add-counter').val();
    let tbody = $('#levels > tbody');

    for (let i = 0; i < add_counter; i++) {
        let lastID = tbody.find("tr").last().find('input[name="id"]').val();
        let incrementId = parseInt(lastID) || 0;
        let trLast = $('#level_template').html().replace(/%level_id%/g, ++incrementId);

        tbody.append(trLast);
    }

    return false;
}
