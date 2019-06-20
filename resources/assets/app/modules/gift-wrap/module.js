import sortableInit from "./handlers/sortableInit";
import assetChanged from "./handlers/assetChanged";
import addRow from "./listeners/addRow";
import fastSavePage from "./handlers/fastSavePage";
import removeRow from "./handlers/removeRow";

$(document)

    /**
     * Change asset id in input
     */
    .on('change', '.asset-id', assetChanged)

    /**
     * Remove row
     */
    .on('click', '.ajax-confirm-action-custom', removeRow);

/**
 * Add row listener
 */
addRow();

/**
 * Sortable init
 */
$('.sortable').each(sortableInit);

/**
 * Save all page
 */
$('.fast-save-page-custom').click(fastSavePage);