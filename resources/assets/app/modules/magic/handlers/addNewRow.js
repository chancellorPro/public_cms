/**
 * Add next rows to the magic config grid
 *
 * @returns {boolean}
 */
export function addNewRow() {
    const add_counter = $('.add-counter').val();
    const tbody = $('#magic > tbody');

    for (let i = 0; i < add_counter; i++) {
        let lastID = tbody.find("tr").last().find('input[name="id"]').val();
        let incrementId = parseInt(lastID) || 0;
        let trLast = $('#magic_template').html().replace(/%magic_id%/g, ++incrementId);

        tbody.append(trLast);
    }

    return false;
}
