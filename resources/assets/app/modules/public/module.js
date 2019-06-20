import http from "components/http/RequestBuilder";

$(document)

    /**
     * NLA order
     */
    .on('change', '#order', function () {
        new http('change-order')
            .method('POST')
            .data({order: $(this).val()})
            .success(response => {
                location.reload();
            })
            .send();
    })

    /**
     * NLA qty
     */
    .on('change', '#qty', function () {
        new http('change-per-page')
            .method('POST')
            .data({record_per_page: $(this).val()})
            .success(response => {
                const [ head, tail ] = location.href.split( '?' );
                location.href = head + '?' + tail.replace(new RegExp(`page=[^&]*|page=[^&]*&`), '');
            })
            .send();
    });
