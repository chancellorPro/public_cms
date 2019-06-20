import {changeTab} from "./handlers/changeTab";

$(document)

    /**
     * Copy ids
     */
    .on('click', '.copy', function () {
        $('#' + $(this).data('target')).select();
        document.execCommand("copy");
    })

    /**
     * Change url on tab change
     */
    .on('click', '.deploy-tabs .nav-link', changeTab);

