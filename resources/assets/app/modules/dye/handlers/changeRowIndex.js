/**
 * Change row index
 *
 * @returns {boolean}
 */
export function changeRowIndex() {
    let rowIndex = $(this).val();
    let row = $(this).closest('tr').find('input, select');

    row.each(function (index, item) {
        let oldName = $(item).attr('name');
        let newName = oldName.slice(0, 4) + rowIndex +  oldName.slice(oldName.indexOf(']'));
        $(item).attr('name', newName);
    });

    return false;
}
