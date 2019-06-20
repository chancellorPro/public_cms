/**
 * Add next rows to the announcements config grid
 *
 * @returns {boolean}
 */
export function addNewRow() {
    const add_counter = $('.add-counter').val();
    const tbody = $('#announcements > tbody');
    const lastID = tbody.find("tr").last().find('.ann_id').val();
    const incrementId = (parseInt(lastID) + 1) || 1;

    for (let i = 0; i < add_counter; i++) {
        let trLast = $('#announcements_template').html().replace(/%announcement_id%/g, i + incrementId);
        tbody.append(trLast);
        tbody.find('.select2').select2();
    }

    return false;
}
