/**
 * Handler for change tab
 */
export function assetTab(e) {
    const currentElement = $(this).find('a');
    let url = window.location.href.split('?')[0];
    let direction = currentElement.attr('href').replace('#', '');
    url += "?activeTab=" + direction;
    window.location = url
}
