import updateIndexes from "./listeners/updateIndexes";
import collapseState from "./handlers/collapseState";
import collapseStates from "./handlers/collapseStates";
import removeActionTypeState from "./handlers/removeActionTypeState";

import "./style.scss";

/**
 * Update indexes
 */
updateIndexes();

$(document)

    /**
     * Collapse one state
     */
    .on('click', '.collapse-link', collapseState)

    /**
     * Collapse all states
     */
    .on('click', '.hide-states', collapseStates)

    /**
     * Remove state
     */
    .on('click', '.rm-action-type-states', removeActionTypeState);
