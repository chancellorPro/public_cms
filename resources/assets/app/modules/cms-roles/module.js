import {changeTab} from "./handlers/changeTab";

$(document)

    /**
     * Change url on tab change
     */
    .on('click', '.deploy-tabs .nav-link', changeTab);

