import dropZoneInit from "listeners/dropZoneInit";
import {COLLECTION_SHOW_FORM} from "./constants";
import fastSave from "./handlers/fastSave";
import markInputAsChanged from "./handlers/markInputAsChanged";
import sortableInit from "./handlers/sortableInit";
import hideAdditionalRows from "./handlers/hideAdditionalRows";

import './style.scss';

/**
 * Preview Image (DropZone init)
 */
$('.show-form').click(dropZoneInit(COLLECTION_SHOW_FORM));

/**
 * Fast save collection
 */
$('.collection-fast-save').click(fastSave);

/**
 * Mark inputs as changed
 */
$('.fast-save-container').find('input').change(markInputAsChanged);

/**
 * Sortable init
 */
$('.sortable').each(sortableInit);

/**
 * Hide additional rows
 */
$('.hide-slots').click(hideAdditionalRows);
