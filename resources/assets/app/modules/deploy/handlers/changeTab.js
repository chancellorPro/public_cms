
/**
 * Handler for change tab
 */
export function changeTab(e) {
    const currentElement = $(this);
    let url = window.location.href.split('?')[0];
    let direction = currentElement.attr('href').replace('#', '');
    url += "?direction=" + direction;
    history.pushState({
        id: 'deploy'
    }, 'Deploy', url);
}
