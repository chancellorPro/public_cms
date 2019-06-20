import {changeTab} from "./handlers/changeTab";
import fastSavePage from "handlers/fastSavePage";

$(document)
    /**
     * Change url on tab change
     */
    .on('click', '.deploy-tabs .nav-link', changeTab)
    /**
     * Save all page
     */
    .on('click', '.fast-save-page-custom', fastSavePage)