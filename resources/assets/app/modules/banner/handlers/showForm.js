import dropZoneInit from "listeners/dropZoneInit";
import {BANNER_SHOW_FORM} from "../constants";
import showForm from "../listeners/showForm";

/**
 * Show form handler
 */
export default function () {
    /**
     * Dropzone Init
     */
    dropZoneInit(BANNER_SHOW_FORM);

    /**
     * Init showForm listener
     */
    showForm();
}
