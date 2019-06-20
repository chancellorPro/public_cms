import Sortable from 'sortablejs';

/**
 * Sortable Init
 */
export default function () {
    new Sortable(this, {
        group: 'shops',
        removeCloneOnHide: true,
        onEnd: function(e) {
            new Promise(function (resolve) {
                resolve({
                    radio: $(e.item).find('.radio'),
                    parent: $(e.item).closest('.table'),
                });
            }).then(data => {
                if (data.parent.find('.radio.checked:gt(0)').length) {
                    data.radio.removeClass('checked');
                    data.radio.prop('checked', false);
                }
            });
        }
    });
}
