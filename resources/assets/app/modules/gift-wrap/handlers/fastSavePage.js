import fastSavePage from "handlers/fastSavePage";
import errorHandler from "components/http/errorHandler";
import positionUpdate from "../helpers/positionUpdate";

/**
 * Fast save data from the all page
 *
 * @param e
 *
 * @returns {boolean}
 */
export default function (e) {
    try {
        const assets = {};
        $('#gift-wraps-container').find('.asset-id').each(function () {
            if (assets[this.value] === true) {
                throw new Error(this.value);
            }

            if (this.value.length) {
                assets[this.value] = true;
            }
        });
    } catch (err) {
        errorHandler({'message': 'Duplicate asset ' + err.message});
        return false;
    }

    /**
     * Position update
     */
    positionUpdate();

    fastSavePage.bind(this)(e);
}
