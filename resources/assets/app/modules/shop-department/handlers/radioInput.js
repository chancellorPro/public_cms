/**
 * Radio input from checkbox
 * Because input[type=radio] did not work correctly
 */
export default function () {
    const currentItem = $(this);
    const allItems = currentItem.closest('.table').find('.radio');

    allItems.prop('checked', false);
    allItems.removeClass('checked');

    currentItem.prop('checked', true);
    currentItem.addClass('checked');
}
