/**
 * Add next rows to the dye config grid
 *
 * @returns {boolean}
 */
export function addNewRow() {
    const add_counter = $('.add-counter').val();
    const tbody = $('tbody.container');

    let lastIDS = [];
    let incrementId = 1;
    tbody.find("tr").each(function (n, item) {
        if ($(item).data('id')) {
            lastIDS.push($(item).data('id'));
        }
    });
    if (lastIDS.length) {
        incrementId = (Math.max.apply(Math, lastIDS) + 1) || 1;
    }

    for (let i = 0; i < add_counter; i++) {
        let trLast = $('#template').html().replace(/%id%/g, i + incrementId);
        tbody.prepend(trLast);
    }

    return false;
}
