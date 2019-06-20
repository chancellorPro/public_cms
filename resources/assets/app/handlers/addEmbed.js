import observer from "components/observer/EventObserver";

/**
 * Add embed element
 *
 * @param e
 *
 * @returns {boolean}
 */
export default function (e) {
    e.preventDefault();

    const currentButton = $(this);
    const target = currentButton.data('target');
    const template = currentButton.data('template');
    const idPlaceholder = currentButton.data('idplacepolder');

    let rowId = currentButton.data('rowid');
    currentButton.data('rowid', ++rowId);

    let embedForm = $('#'+ template).html();
    const embedBlockId = rowId + (new Date().getTime()).toString(16);
    embedForm = embedForm.replace(/%embedBlockId%/g, embedBlockId);

    if (!!idPlaceholder) {
        embedForm = embedForm.replace( new RegExp(idPlaceholder, "g"), rowId)
    }

    $('#' + target).append(embedForm);

    /**
     * Event dispatch
     */
    const event = currentButton.data('event');
    if (event && event.length) {
        observer.dispatch(event, {
            embedBlockId: embedBlockId
        })
    }
    currentButton.trigger('ai_animation');

    return false;
}
