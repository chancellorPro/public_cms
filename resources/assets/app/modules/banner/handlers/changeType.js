import {TYPE_SELECT_ID} from "../constants";

/**
 * Change type handler
 * Hide/show some fields
 *
 * @returns {boolean}
 */
export default function () {
    const select = document.getElementById(TYPE_SELECT_ID);

    if (!select || select.selectedIndex === -1) {
        return false;
    }

    if (select.options.length && select.options[select.selectedIndex]) {
        let selectedElement = select.options[select.selectedIndex];

        $('.banner-type').addClass('hide');
        $('.banner-type-' + selectedElement.value).removeClass('hide');
    }

    return false;
}
