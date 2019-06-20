/**
 * Add next rows to the localization config grid
 *
 * @returns {boolean}
 */
export function addNewRow() {
    let tbody = $('#localizations > tbody');
    let template = $('#localization_template').html();

    tbody.append(template);

    return false;
}
