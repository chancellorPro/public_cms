import RequestBuilder from "components/http/RequestBuilder";

export default function (e) {
    e.preventDefault();

    new RequestBuilder(this.href)
        .success(result => {
            $('#collection-number')
                .val(result.collection_id)
                .removeClass('hide');
        })
        .send();

    return false;
}