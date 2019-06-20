import {changeTab} from "./handlers/changeTab";

$(document)

    .ready(function () {
        $(".special-prize-save-container label:contains('Limit')").html("You can send");
        $('.special-prize-save-container input').attr('readonly', true).attr('disabled', true);
        $('.add-embed, .remove-embed').remove();

    })

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

