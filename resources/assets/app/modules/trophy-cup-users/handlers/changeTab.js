
/**
 * Handler for change tab
 */
export function changeTab(e) {
    const currentElement = $(this);
    let url = window.location.href.split('?')[0];
    let direction = currentElement.attr('href').replace('#', '');
    url += "?env=" + direction;
    history.pushState({
        id: 'trophy-cup-users'
    }, 'Trophy cup users', url);
    window.location = url
}
