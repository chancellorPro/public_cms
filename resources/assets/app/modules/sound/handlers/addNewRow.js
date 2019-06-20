/**
 * Add next rows to the sound config grid
 *
 * @returns {boolean}
 */
export function addNewRow() {
    const add_counter = $('.add-counter').val();
    const tbody = $('#sound > tbody');
    const trLast = $('#sound_template').html();
    const lastID = tbody.find("tr").last().find('.sound_id').val();
    const incrementId = (parseInt(lastID) + 1) || 1;

    for (let i = 0; i < add_counter; i++) {
        tbody.append(trLast.replace(/%sound_id%/g, i + incrementId));
        tbody.find('.select2').select2();
    }

    return false;
}
