import RequestBuilder from "components/http/RequestBuilder";

/**
 * Show last makeup kit ID
 *
 * @param e
 * @returns {boolean}
 */
export default function (e) {
    e.preventDefault();

    new RequestBuilder(this.href)
        .success(result => {
            $('#last-makeup-kit-id')
                .val(result.makeup_kit_id);
        })
        .send();

    return false;
}