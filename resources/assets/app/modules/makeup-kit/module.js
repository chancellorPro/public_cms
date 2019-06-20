import dropZoneInit from "listeners/dropZoneInit";
import {MAKEUP_KIT_SHOW_FORM} from "modules/makeup-kit/constants";

/**
 * Preview Image (DropZone init)
 */
$('.show-form').click(dropZoneInit(MAKEUP_KIT_SHOW_FORM));
