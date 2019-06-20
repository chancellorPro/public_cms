import {assetTab} from "./handlers/assetTab";
import {changeTab} from "./handlers/changeTab";
import {saveState} from "./handlers/saveState";
import {updateList} from "./handlers/updateList";
import http from "components/http/RequestBuilder";

$(document)

    /**
     * Change url on tab change
     */
    .on('click', '.nav-link', changeTab)

    /**
     * Change url on tab change
     */
    .on('click', '.asset-tab', assetTab)

    /**
     * Remove empty row
     */
    .on('click', '.delete-row', function () {
        $(this).closest('tr').remove();
    })

    /**
     * Save state
     */
    .on('click', '.update-assign', updateList)

    .on('click', '.ajax-submit-action', function () {
        $(this).append('<i class="fa fa-spinner fa-spin"></i>')
    })

    /**
     * Update nla list category
     */
    .on('click', '.asset-assign', saveState)

    /**
     * NLA qty
     */
    .on('change', '#qty', function () {
        new http('change-per-page')
            .method('POST')
            .data({record_per_page: $(this).val()})
            .success(response => {
                const [ head, tail ] = location.href.split( '?' );
                location.href = head + '?' + tail.replace(new RegExp(`page=[^&]*|page=[^&]*&`), '');
            })
            .send();
    });

