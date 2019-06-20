/**
 * Add next rows to the dye config grid
 *
 * @returns {boolean}
 */
export function addNewRow() {
    const add_counter = $('.add-counter').val();
    const tbody = $('tbody.group-event-save-container');

    let lastIDS = [];
    let incrementId = 1;
    tbody.find("tr").each(function (n, item) {
        lastIDS.push($(item).data('id'));
    });

    if(lastIDS.length){
        incrementId = (Math.max.apply(Math,lastIDS) + 1) || 1;
    }

    for (let i = 0; i < add_counter; i++) {
        let trLast = $('#template').html().replace(/%id%/g, i + incrementId);
        tbody.prepend(trLast);
        $('.date-field').datetimepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            minView: '2'
        });
    }

    return false;
}
