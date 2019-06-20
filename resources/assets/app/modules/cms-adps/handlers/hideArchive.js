/**
 * Handler of archive categories on adp page
 */
export function hideArchive(e) {
    e.preventDefault();
    const currentElement = $(this);
    currentElement.addClass('hidden');
    $('.show-archive').removeClass('hidden');
    $('.archive-categories-list').html('');
}
