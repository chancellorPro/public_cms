/**
 * Handler of tasks on adp page
 */
export function showTasks(e) {
    e.preventDefault();
    const currentElement = $(this);
    currentElement.addClass('hidden');
    $('.hide-tasks').removeClass('hidden');
    $('.tasks-list').show('slow');
}
