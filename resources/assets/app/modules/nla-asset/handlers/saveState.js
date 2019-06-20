import http from "components/http/RequestBuilder";
import successHandler from "components/http/successHandler";
import notifyError from "components/notify/notifyError";

/**
 * Update row to the grid
 *
 * @returns {boolean}
 */
export function saveState () {
    const category = $('[name="category"]').val();
    const asset_ids = $('[name="assets_ids"]');

    if(!asset_ids.length) {
        notifyError('Nothing to save!');
    } else {
        new http('nla-assign')
            .method('POST')
            .data({asset_ids: asset_ids.val(), category: category})
            .success(response => {
                successHandler(response);
                asset_ids.val('');
            })
            .send();
    }

    return false;
}
