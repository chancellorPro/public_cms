import Sortable from 'sortablejs';
import positionUpdate from "modules/gift-wrap/helpers/positionUpdate";

/**
 * Sortable Init
 */
export default function () {
    const _this = this;
    new Sortable(_this, {
        removeCloneOnHide: true,
        onEnd: function() {
            positionUpdate();
        }
    });
}
