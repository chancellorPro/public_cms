/**
 * Add a new shop in a departments grid
 */
export default function (e) {
    e.preventDefault();

    const currentBtn = $(this);
    const table = currentBtn.closest('.shops-table').find('tbody');
    const departmentId = currentBtn.data('department');
    let counter = parseInt(currentBtn.data('count'));
    const template = $('#shop-template')
        .html()
        .replace(new RegExp('%departmentId%', "g"), departmentId)
        .replace(new RegExp('%index%', "g"), counter++);

    currentBtn.data('count', counter);

    table.append(template);

    return false;
}