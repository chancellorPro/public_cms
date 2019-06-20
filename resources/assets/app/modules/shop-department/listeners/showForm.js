import observer from "components/observer/EventObserver";
import {SHOP_DEPARTMENT_SHOW_FORM} from "../constants";
import errorHandler from "components/http/errorHandler";
import getFilePath from "helpers/getFilePath";
import DropzoneBuilder from "components/dropzone/DropzoneBuilder";

/**
 * Dropzone init after the modal opened
 */
export default function () {
    observer.subscribe(SHOP_DEPARTMENT_SHOW_FORM, () => {
        /**
         * Preview
         */
        dropzoneInit(document.getElementById('dropzone'), document.getElementById('preview-url'));

        /**
         * Preview Small
         */
        dropzoneInit(document.getElementById('dropzone-small'), document.getElementById('preview-url-small'));
    });
}

/**
 * Dropzone Init
 *
 * @param {HTMLElement} dropzoneElement
 * @param {HTMLElement} previewUrlElement
 *
 * @returns {boolean}
 */
function dropzoneInit(dropzoneElement, previewUrlElement) {
    if (!dropzoneElement) {
        return false;
    }

    /**
     * Dropzone initialization
     */
    const dropzoneBuilder = new DropzoneBuilder(dropzoneElement)
        .setUploadUrl(dropzoneElement.dataset.url)
        .error((file, response) => {
            errorHandler(response);
            $(previewUrlElement).val('');
        })
        .cancel(() => {
            $(previewUrlElement).val('');
        })
        .success((file, response) => {
            $(dropzoneElement).find('.dz-filename span').text(response.file_name);
            previewUrlElement.value = response.file_name;
        });

    /**
     * Set preview
     */
    if (previewUrlElement.value.length) {
        dropzoneBuilder
            .setPreview(
                previewUrlElement.value,
                getFilePath(dropzoneElement.dataset.folder, previewUrlElement.value)
            );
    }

    /**
     * Dropzone build
     */
    dropzoneBuilder.build();
}