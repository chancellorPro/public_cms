function init_filter_col(url) {

    $(document)
        .on('click', '#list-filter', function () {
            filter();
        })
        .on('click', '#clear-filter', function () {
            filter(true);
        });

    $('.filter').keypress(function (e) {
        if (e.which == 13) {
            filter();
        }
    });

    function filter(clear = false) {
        let filter = [];
        if (!clear) {
            var filterFilds = $("select.filter, input.filter").serializeArray();
            
            $.each(filterFilds, function (key, row) {
                if (row.value != '') {
                    filter.push(row.name + '=' + row.value);
                }
            });
        } else {
            filter.push('clear_filter=1');
        }
 
        
        window.location.href = url + (url.indexOf('?') == -1 ? '?' : '&') + filter.join('&');
    }
}


