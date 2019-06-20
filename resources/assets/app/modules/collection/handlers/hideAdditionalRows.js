/**
 * Hide additional rows
 *
 * @param e
 *
 * @returns {boolean}
 */
export default function (e) {
    e.preventDefault();

    $('.additional-data').toggleClass('hide');

    return false;
}
