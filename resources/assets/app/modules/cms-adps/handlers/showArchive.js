import http from "components/http/RequestBuilder";

/**
 * Handler of archive categories on adp page
 */
export function showArchive(e) {
    e.preventDefault();
    const currentElement = $(this);
    currentElement.addClass('hidden');
    $('.hide-archive').removeClass('hidden');
    
    let action = currentElement.attr('href');
    new http(action)
            .method('get')
            .success(response => {
                $('.archive-categories-list').html(response);
            })
            .send();
    
}
