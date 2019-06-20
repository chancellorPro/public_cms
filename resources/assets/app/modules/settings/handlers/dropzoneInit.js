import DropzoneBuilder from "components/dropzone/DropzoneBuilder";
import errorHandler from "components/http/errorHandler";
import getFilePath from "helpers/getFilePath";

/**
 * Dropzone init
 *
 * @param _
 * @param item
 */
export default function (_, item) {
    const dropzoneContainer = $(item);
    const previewHiddenInput = dropzoneContainer.find('input');

    /**
     * Dropzone initialization
     */
    const dropzoneBuilder = new DropzoneBuilder(item)
        .setUploadUrl(dropzoneContainer.data('url'))
        .error((file, response) => {
            errorHandler(response);
            previewHiddenInput.val('');
        })
        .cancel(() => {
            previewHiddenInput.val('');
        })
        .success((file, response) => {
            $('.dz-filename span').text(response.file_name);
            previewHiddenInput.val(response.file_name);
        });

    /**
     * Set preview
     */
    if (!!previewHiddenInput.val()) {
        dropzoneBuilder
            .setPreview(
                previewHiddenInput.val(),
                getFilePath(dropzoneContainer.data('folder'), previewHiddenInput.val())
            );
    }

    /**
     * Dropzone build
     */
    dropzoneBuilder.build();
}