/**
 * Add next rows to the dye config grid
 *
 * @returns {boolean}
 */
export function addNewRow() {
    const add_counter = $('.add-counter').val();
    const tbody = $('#dye > tbody');
    const trLast = $('#dye_template').html();

    for (let i = 0; i < add_counter; i++) {
        tbody.append(trLast);

        let lastRow = tbody.find("tr").last().find('.cp2');
        lastRow.each(function (index, item) {
            $(item).colorpicker({});
        });

    }

    return false;
}
