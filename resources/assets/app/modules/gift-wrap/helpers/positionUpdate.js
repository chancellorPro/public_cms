/**
 * Position update
 */
export default function () {
    $('.position').each(function (index) {
        const position = $(this);
        if (parseInt(position.val()) !== index) {
            position.val(index);
            position.change();
        }
    });
}
