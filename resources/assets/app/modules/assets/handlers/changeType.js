/**
 * SUB_TYPES - it is a global object
 * Inited in asset/form.blade.php
 */
export default function () {
    setSubtypes(this.value, this.dataset.subtype);
}

const assetFormSubtype = $("#subtype");
const assetFormActionType = $('#asset-form-action-type');
const assetFormCollection = $('#asset-form-collection');
const prices = $('.prices');

function setSubtypes(type, subtype) {
    assetFormSubtype
        .empty()
        .select2({
            data: SUB_TYPES[type]
        })
        .val(subtype)
        .change();

    /**
     * Default state
     */
    hide(assetFormActionType);
    hide(assetFormCollection);
    show(prices);

    switch (parseInt(type)) {

        // Furniture
        case 1:
            show(assetFormActionType);
            break;

        // Clothes
        case 2:
            show(assetFormCollection);
            break;

        // Body Part
        case 5:
            hide(prices);
            break;
    }
}

function hide(element) {
    element.addClass('hide');
}

function show(element) {
    element.removeClass('hide');
}