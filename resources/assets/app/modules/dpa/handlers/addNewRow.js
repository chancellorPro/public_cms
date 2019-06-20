/**
 * Add next rows to the levels config grid
 *
 * @returns {boolean}
 */
export function addNewRow() {
    const add_counter = $('.add-counter').val();
    const tbody = $('#dpa > tbody');
    const lastID = tbody.find("tr").last().find('.dpa_id').val();
    let incrementId = (parseInt(lastID) + 1) || 1;

    for (let i = 0; i < add_counter; i++) {
        let trLast = $('#dpa_template').html().replace(/%dpa_id%/g, i + incrementId);

        tbody.append(trLast);
    }

    return false;
}
