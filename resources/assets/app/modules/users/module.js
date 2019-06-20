import searchUserAssets from "./listeners/searchUserAssets";
import submitUserPartForm from "./listeners/submitUserPartForm";
import deleteNeighbor from "./listeners/deleteNeighbor";
import addNeighbor from "./listeners/addNeighbor";
import loadPlacementAssets from "./handlers/loadPlacementAssets";
import hidePlacementAssets from "./handlers/hidePlacementAssets";
import changePlacement from "./handlers/changePlacement";
import changeRandomNeighbors from "./handlers/changeRandomNeighbors";
import "./styles.scss";

/**
 * Search user assets listener
 */
searchUserAssets();

/**
 * Submit user part form listener
 */
submitUserPartForm();

/**
 * Delete Neighbor
 */
deleteNeighbor();

/**
 * Add Neighbor
 */
addNeighbor();

$(document)

    /**
     * Load assets in placement
     */
    .on('click', '.load-assets', loadPlacementAssets)

    /**
     * Change placement in Add Assets block
     */
    .on('change', '#placement-for-asset', changePlacement)

    /**
     * Change mode for add neighbors
     */
    .on('change', '#is-random-neighbors', changeRandomNeighbors)

    /**
     * Hide assets in placement
     */
    .on('click', '.hide-assets', hidePlacementAssets);
