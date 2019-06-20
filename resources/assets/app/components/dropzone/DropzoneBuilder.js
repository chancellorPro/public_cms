import Dropzone from 'dropzone';

/**
 * Loading text
 * It will be shown after the start of image uploading
 *
 * @type {string}
 */
const LOADING_TEXT = 'Loading...';

/**
 * Dropzone builder
 */
export default class {

    /**
     * Constructor
     *
     * @param dropzoneContainer
     * @param config
     */
    constructor(dropzoneContainer, config = {}) {
        this._config = config;
        this._dropzoneContainer = dropzoneContainer;
        this._cancelButton = $(dropzoneContainer).find('.dropzone-cancel');
    }

    /**
     * Set url to uploading
     *
     * @param url
     */
    setUploadUrl(url) {
        this._uploadUrl = url;
        return this;
    }

    /**
     * Set default preview image
     *
     * @param name
     * @param url
     */
    setPreview(name, url) {
        this._preview = {
            name: name,
            url: url,
        };
        return this;
    }

    /**
     * Set error handler
     *
     * @param callback
     */
    error(callback) {
        this._errorCallback = callback;
        return this;
    }

    /**
     * Set cancel handler
     *
     * @param callback
     */
    cancel(callback) {
        this._cancelCallback = callback;
        return this;
    }

    /**
     * Set success handler
     *
     * @param callback
     */
    success(callback) {
        this._successCallback = callback;
        return this;
    }

    /**
     * Build dropzone
     * @returns {Dropzone}
     */
    build() {
        /**
         * this
         */
        const _dropzoneBuilder = this;

        /**
         * Call after fail
         */
        const dropzoneFail = function () {
            $(_dropzoneBuilder._dropzoneContainer).removeClass('dz-started');
            $(_dropzoneBuilder._dropzoneContainer).find('.dz-preview').remove();
        };

        /**
         * Default configuration
         *
         * @type object
         */
        const config = {
            url: this._uploadUrl,
            thumbnailWidth: null,
            thumbnailHeight: null,
            uploadMultiple: false,
            acceptedFiles: 'image/*',
            headers: {
                'x-csrf-token': CSRF_TOKEN
            },

            init: function() {
                /**
                 * Set current image in the dropzone if it exists
                 */
                if (!!_dropzoneBuilder._preview && !!_dropzoneBuilder._preview.url) {
                    this.emit("addedfile", _dropzoneBuilder._preview);
                    this.emit("thumbnail", _dropzoneBuilder._preview, _dropzoneBuilder._preview.url);
                }

                /**
                 * Added file handler
                 */
                this.on("addedfile", function () {
                    $(_dropzoneBuilder._dropzoneContainer).find('.dz-filename span').text(LOADING_TEXT);
                });

                /**
                 * Error handler
                 */
                this.on("error", function (file, response) {
                    dropzoneFail();
                    if (!!_dropzoneBuilder._errorCallback) {
                        _dropzoneBuilder._errorCallback(file, response)
                    }
                });

                /**
                 * Success handler
                 */
                this.on("success", function (file, response) {
                    if (!!_dropzoneBuilder._successCallback) {
                        _dropzoneBuilder._successCallback(file, response)
                    }
                });
            }
        };

        /**
         * Clear button handler
         * Clear file info in dropzone
         */
        if (!!this._cancelButton) {
            this._cancelButton.click(function () {
                dropzoneFail();
                if (!!_dropzoneBuilder._cancelCallback) {
                    _dropzoneBuilder._cancelCallback();
                }
            });
        }

        /**
         * Dropzone build
         */
        return new Dropzone(this._dropzoneContainer, {...config, ...this._config});
    }
}
