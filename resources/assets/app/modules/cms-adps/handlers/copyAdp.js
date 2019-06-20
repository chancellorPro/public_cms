/**
 * Handler for copy adp ids to clipboard
 */
export function copyAdp(e) {
    e.preventDefault();
    const adpIdsField = $('input[name="adp_ids"]');
    let adpIds = [];

    $('.rows-content').find('input[name="for_copy"]:checked').each(function (n, item) {
        adpIds.push($(item).data('id'))
    });

    adpIdsField.val(adpIds);
    adpIdsField.select();
    document.execCommand("copy");
    // adpIdsField.val([]);
}
