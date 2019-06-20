/**
 * Get form data
 *
 * @param {jQuery} form Form element
 *
 * @returns {{}}
 */
export default function(form) {
    const formData = {};

    let formItems = form.find('input, select');
    if (!formItems.length) {
        formItems = form;
    }

    formItems.each(function () {
        const currentItem = $(this);
        switch (currentItem.attr('type')) {
            case 'radio':
            case 'checkbox':
                formData[currentItem.attr('name')] = !!currentItem.prop( "checked" ) * 1;
                break;
            default:
                formData[currentItem.attr('name')] = currentItem.val();
        }
    });

    return formData;
}
