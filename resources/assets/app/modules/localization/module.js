import {saveLocalizationState} from "./handlers/saveLocalizationState";
import {addNewRow} from "./handlers/addNewRow";
import {removeRow} from "./handlers/removeRow";

$(document)

    /**
     * Add next rows to the localizations grid
     */
    .on('click', '.create-row', addNewRow)

    /**
     * Save the row
     */
    .on('click', '.update-row', saveLocalizationState)

    /**
     * Remove the row
     */
    .on('click', '.remove-row', removeRow);
