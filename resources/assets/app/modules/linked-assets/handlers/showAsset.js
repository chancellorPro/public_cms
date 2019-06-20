import http from "components/http/RequestBuilder";

/**
 * Handler for show asset
 */
export function showAsset(e) {
    e.preventDefault();
    const currentElement = $(this);
    let action = SWOW_ASSET_ROUTE + '?id=' + currentElement.val();
    new http(action)
        .method('get')
        .success(response => {
            console.log(response);
            if(response.hasOwnProperty('data')) {
                if(response.data.hasOwnProperty('name')) {
                    currentElement.parents('tr').find('.asset-name').html(response.data.name);
                }
                if(response.data.hasOwnProperty('preview_url')) {
                    currentElement.parents('tr').find('.asset-preview img').attr('src', response.data.preview_url);
                    currentElement.parents('tr').find('.asset-preview .list-thumbnail').data('full', response.data.preview_url);
                }
            }

        })
        .send();
}
