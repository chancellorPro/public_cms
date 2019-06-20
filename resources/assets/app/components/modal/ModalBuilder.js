const modalsContainer = $('body');

const MODAL_SIZES = {
    sm: 'modal-sm',
    md: 'modal-md',
    lg: 'modal-lg',
};

/**
 * Unique index of the modal
 *
 * @type {number}
 */
let modalIndex = 0;

/**
 * Counter of the modals at the page
 *
 * @type {number}
 */
let modalCounter = 0;

/**
 * Modal Builder
 */
export default class {

    constructor() {
        modalIndex++;
        this._id = 'modals-container-item-' + modalIndex;
    }

    size(size) {
        if (!!MODAL_SIZES[size]) {
            this._size = MODAL_SIZES[size];
        }

        return this;
    }

    header(header) {
        this._header = header;

        return this;
    }

    body(body) {
        this._body = body;

        return this;
    }

    footer(footer) {
        this._footer = footer;

        return this;
    }

    dataset(dataset) {
        this._dataset = dataset;

        return this;
    }

    _getID() {
        return this._id;
    }

    _getSize() {
        return !!this._size ? this._size : MODAL_SIZES.md;
    }

    _getHeader() {
        if (!!this._header) {
            return `
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                   <h4 class="modal-title">${this._header}</h4>
                </div>`;
        }
        return '';
    }

    _getFooter() {
        let result = null;
        if (!!this._footer) {
            result = $(`<div class="modal-footer"></div>`)
                .append($(`
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                        Cancel
                    </button>
                `))
                .append(this._footer);
        }
        return result;
    }

    _getBody() {
        let result = null;
        if (!!this._body) {
            result = $(`<div class="modal-body"></div>`)
                .append(this._body);
        }
        return result;
    }

    /**
     * Set callback that will be call before build modal
     *
     * @param callback
     */
    beforeBuild(callback) {
        this._beforeBuildCallback = callback;
        return this;
    }

    _beforeBuild() {
        if (typeof this._beforeBuildCallback === "function") {
            this._beforeBuildCallback();
        }
    }

    /**
     * Set callback that will be call after build modal
     *
     * @param callback
     */
    afterBuild(callback) {
        this._afterBuildCallback = callback;
        return this;
    }

    _afterBuild() {
        if (typeof this._afterBuildCallback === "function") {
            this._afterBuildCallback();
        }
    }

    modal(content) {
        /**
         * Data attributes
         * @type {Array}
         */
        let dataset = [];
        if (!!this._dataset) {
            for (var name in this._dataset) {
                dataset.push(`data-${name}="${this._dataset[name]}"`);
            }
        }

        let html = $(`
            <div id="${ this._getID() }" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" ${dataset.join(' ')}>
                <div class="modal-dialog modal-dialog-centered ${this._getSize()}">
                    <div class="modal-content"></div>
                </div>
            </div>`);

        if (!!content) {
            this.body(content);
        }

        /**
         * Call the beforeBuild callback
         */
        this._beforeBuild();

        html.find('.modal-content')
            .append(this._getHeader())
            .append(this._getBody())
            .append(this._getFooter());

        modalsContainer.append(html);

        /**
         * Call the afterBuild callback
         */
        this._afterBuild();

        /**
         * update counter of modals at the page
         */
        modalCounter++;

        $('#' + this._getID())
            .on('hidden.bs.modal', () => {
                modalCounter--;
                $('#' + this._getID())
                    .off('hidden.bs.modal')
                    .remove();
            })
            .modal();
    }
}

/**
 * Get counter of modals at the page
 *
 * @returns {number}
 */
export function getModalCounter() {
    return modalCounter;
}
