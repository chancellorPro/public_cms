/**
 * Handler of select at the adp edit page
 */
export function bundleVersionSelect() {
    const bundles = $('.bundles');

    bundles.addClass('hide');

    if (this.value.length) {
        if (this.value === 'both') {
            bundles.removeClass('hide');
        } else {
            $('#' + this.value).removeClass('hide');
        }
    }
}
