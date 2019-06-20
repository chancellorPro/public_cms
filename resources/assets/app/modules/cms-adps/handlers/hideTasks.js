/**
 * Handler of tasks on adp page
 */
export function hideTasks(e) {
    e.preventDefault();
    const currentElement = $(this);
    currentElement.addClass('hidden');
    $('.show-tasks').removeClass('hidden');
    $('.tasks-list').hide('slow');
}
