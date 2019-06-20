/**
 * Add next rows to the sound config grid
 *
 * @returns {boolean}
 */
export function addNewRow() {
    const add_counter = $('.add-counter').val();
    const tbody = $('#daily_loot > tbody');
    const trLast = $('#daily_loot_template').html();
    let lastIDS = [];
    let incrementId = 1;
    tbody.find("tr").each(function (n, item) {
        if(parseInt($(item).find('input').first().val())){
            lastIDS.push(parseInt($(item).find('input').first().val()));
        }
    });

    if(lastIDS.length){
        incrementId = (Math.max.apply(Math,lastIDS) + 1) || 1;
    }

    for (let i = 0; i < add_counter; i++) {
        tbody.append(trLast.replace(/%rowIndex%/g, i + incrementId));
        tbody.find("tr").last().find('input').first().val(i + incrementId);

        tbody.find('.datepicker')
            .datetimepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                minView: '2'
            });
    }

    return false;
}
