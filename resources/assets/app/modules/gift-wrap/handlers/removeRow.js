import confirmModal from "handlers/confirmModal";

/**
 * Remove embeded element
 */
export default function (e) {
    const buttonUrl = this.href.split('/');
    const parent = $(this).closest('tr');

    e.preventDefault();

    if (parseInt(buttonUrl[buttonUrl.length - 1]) === 0) {
        parent.remove();
        return false;
    }

    confirmModal.bind(this)(e);

    return false;
}
