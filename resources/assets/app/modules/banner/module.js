import showForm from "./handlers/showForm";
import changeType from "./handlers/changeType";
import {TYPE_SELECT_ID} from "./constants";

/**
 * Show edit form of a banner
 */
$('.show-form').click(showForm());

$(document)

    /**
     * Change type handler
     */
    .on('change', '#' + TYPE_SELECT_ID, changeType);
