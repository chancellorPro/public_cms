import http from "components/http/RequestBuilder";

/**
 *Ajax pagination
 */
export default function(e) {
    e.preventDefault();

    const container = $(this).parents('.ajax-pagination').data('container');
   
    new http(this.href)
        .method('get')
        .success(response => {
            $('#' + container).replaceWith(response);
        })
        .send();

    return false;
}


