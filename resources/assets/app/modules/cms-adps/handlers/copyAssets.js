/**
 * Handler for copy assets ids to clipboard
 */
export function copyAssets(e) {
    e.preventDefault();

    const assetIdsField = $('input[name="asset_ids"]');
    let assetIds = [];

    $('.rows-content').find('input[name="for_copy"]:checked').each(function (n, item) {
        assetIds.push($(item).data('asset-id'))
    });

    assetIdsField.val(assetIds);
    assetIdsField.select();
    document.execCommand("copy");
}
