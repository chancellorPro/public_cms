import http from "components/http/RequestBuilder";
import successHandler from "components/http/successHandler";
import notifyError from "components/notify/notifyError";

/**
 * Update row to the grid
 *
 * @returns {boolean}
 */
export function updateList () {
    const assetIds = [];
    const category = $('[name="category"]').val();
    const asignList = $('tbody,container').find(':checkbox:checked');
    asignList.each(function (i, assetId) {
        assetIds.push($(assetId).data('asset'))
    });

    if(!assetIds.length) {
        notifyError('Nothing to save!');
    } else {
        console.log($(this));
        new http($(this).data('route'))
            .method('POST')
            .data({asset_ids: assetIds, category: category})
            .success(response => {
                successHandler(response);
                asignList.prop( "checked", false );
                location.reload()
            })
            .send();
    }

    return false;
}
