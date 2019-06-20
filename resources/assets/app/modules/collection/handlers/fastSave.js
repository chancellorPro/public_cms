import http from "components/http/RequestBuilder";
import {SavedItemNotFound} from "exceptions/SavedItemNotFound";
import getFormData from "helpers/getFormData";
import successHandler from "components/http/successHandler";

const assetPreviewTemplate = $('#asset-preview-template').html();

/**
 * Fast save data from the all page
 *
 * @param e
 *
 * @returns {boolean}
 */
export default function (e) {
    e.preventDefault();

    const currentBtn = $(this);
    const savedItem = $('.fast-save-container');

    if (!savedItem.length) {
        throw new SavedItemNotFound;
    }

    if (savedItem.hasClass('progress')) {
        return false;
    }
    savedItem.addClass('progress');

    /**
     * Get changed data
     */
    const formItems = savedItem.find('.changed');
    const data = getFormData(formItems);

    if (!Object.keys(data).length) {
        savedItem.removeClass('progress');
        return false;
    }

    new http(currentBtn.attr('href'))
        .method('PUT')
        .data(data)
        .complete(() => {
            savedItem.removeClass('progress');
        })
        .success(response => {
            formItems.each(function () {
                const currentItem = $(this);
                if (currentItem.hasClass('asset-id') && !!response.assets[currentItem.val()]) {
                    const currentAsset = response.assets[currentItem.val()];
                    currentItem
                        .closest('.slot')
                        .find('.asset-preview')
                        .html(assetPreviewTemplate
                            .replace( new RegExp('%url%', "g"), currentAsset.preview_url)
                            .replace( new RegExp('%title%', "g"), currentAsset.name))
                }
            }).removeClass('changed');
            successHandler(response);
        })
        .send();

    return false;
}
