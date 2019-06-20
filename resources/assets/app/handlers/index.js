import fastSave from "./fastSave";
import addEmbed from "./addEmbed";
import removeEmbed from "./removeEmbed";
import submitForm from "./submitForm";
import ajaxPagination from "./ajaxPagination";
import confirmModal from "./confirmModal";
import modalData from "./modalData";
import fastSavePage, {CONTAINER_SELECTOR, markChanged} from "./fastSavePage";

$(document)

    /**
     * Open modal with data from server by request
     */
    .on('click', '.ajax-modal-action', modalData)

    /**
     * Open confirm modal
     */
    .on('click', '.ajax-confirm-action', confirmModal)

    /**
     * Submit form data
     */
    .on('click', '.ajax-submit-action', submitForm)

    /**
     * Submit form data
     */
    .on('click', '.ajax-pagination a', ajaxPagination)

    /**
     * Add embed element
     */
    .on('click', '.add-embed', addEmbed)

    /**
     * Remove embed element
     */
    .on('click', '.rm-embed', removeEmbed)

    /**
     * Fast save the data of an entity
     */
    .on('click', '.fast-save', fastSave)

    /**
     * Mark inputs as changed
     */
    .on('change', `${CONTAINER_SELECTOR} input, ${CONTAINER_SELECTOR} select, ${CONTAINER_SELECTOR} textarea`, markChanged);

/**
 * Fast save data on the page
 */
$('.fast-save-page').click(fastSavePage);
