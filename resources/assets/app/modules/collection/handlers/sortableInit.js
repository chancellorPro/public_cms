import Sortable from 'sortablejs';

/**
 * Sortable Init
 */
export default function () {
    const _this = this;
    new Sortable(_this, {
        group: _this.dataset.group,
        removeCloneOnHide: true,
        onEnd: function(e) {
            $(e.target).find(_this.dataset.position).each(function (index) {
                const position = $(this);
                if (parseInt(position.val()) !== index) {
                    position.val(index);
                    position.change();
                }
            });
        }
    });
}
