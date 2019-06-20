const TRASH = 'TRASH';
const TRASH_FIELDS_ID = 'trash-fields';
const SELECT_ID = 'neighbor-activity-type-id';

export default function () {
    const select = document.getElementById(SELECT_ID);

    if (!select || select.selectedIndex === -1) {
        return false;
    }

    if (select.options.length && select.options[select.selectedIndex]) {
        let selectedElement = select.options[select.selectedIndex];

        const trashFields = $('#' + TRASH_FIELDS_ID);
        switch (selectedElement.text.toUpperCase()) {
            case TRASH:
                trashFields.removeClass('hide');
                break;
            default:
                trashFields.addClass('hide');
        }
    }

    return false;
}
