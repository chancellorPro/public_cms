import observer from "components/observer/EventObserver";
import errorHandler from "components/http/errorHandler";
import getFilePath from "helpers/getFilePath";
import DropzoneBuilder from "components/dropzone/DropzoneBuilder";

/**
 * Dropzone init after the modal opened
 */
export default function (EVENT_NAME) {
    observer.subscribe(EVENT_NAME, () => {
        /**
         * Dropzone container
         *
         * @type {HTMLElement | null}
         */
        const dropzoneElement = document.getElementById('dropzone');

        /**
         * Preview URL hidden input
         *
         * @type {HTMLElement | null}
         */
        const previewURL = document.getElementById('preview-url');

        /**
         * Dropzone initialization
         */
        const dropzoneBuilder = new DropzoneBuilder(dropzoneElement)
            .setUploadUrl(dropzoneElement.dataset.url)
            .error((file, response) => {
                errorHandler(response);
                $('#preview-url').val('');
            })
            .cancel(() => {
                $('#preview-url').val('');
            })
            .success((file, response) => {
                $('.dz-filename span').text(response.file_name);
                previewURL.value = response.file_name;
            });

        /**
         * Set preview
         */
        if (previewURL.value.length) {
            dropzoneBuilder
                .setPreview(
                    previewURL.value,
                    getFilePath(dropzoneElement.dataset.folder, previewURL.value)
                );
        }

        /**
         * Dropzone build
         */
        dropzoneBuilder.build();
    });
}

