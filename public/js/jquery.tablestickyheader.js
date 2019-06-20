;(function($){

    $.fn.tableStickyHeader = function(options)
    {
        var settings = $.extend({},$.fn.tableStickyHeader.defaults,options);

        this.each(function() {
            var tbl_src = $(this);
            var thead_src = $(' > thead', tbl_src);

            $('[data-table-sticky-container]', tbl_src).remove();
            if (!!$(' > thead', tbl_src).length) {
                
                thead_src.find('th').each(function(){
                    var src_th_colspan = $(this).attr('colspan');

                    if (src_th_colspan == undefined) {
                        var src_th_width = $(this).outerWidth();
                        $(this).css("width", src_th_width);
                    }
                })
                
                var tbl_dst_html = '<table data-sticky-header="1" style="border-bottom: 1px solid #ddd" ';
                if (typeof tbl_src.attr('cellpadding') !== 'undefined') tbl_dst_html += 'cellpadding="' +tbl_src.attr('cellpadding')+ '"';
                if (typeof tbl_src.attr('class') !== 'undefined') tbl_dst_html += 'class="' +tbl_src.attr('class')+ '"';
                if (typeof tbl_src.attr('style') !== 'undefined') tbl_dst_html += 'style="' +tbl_src.attr('style')+ '"';
                if (typeof tbl_src.width() !== 'undefined') tbl_dst_html += 'width="' +tbl_src.width()+ '"';
                if (typeof tbl_src.attr('border') !== 'undefined') tbl_dst_html += 'border="' +tbl_src.attr('border')+ '"';
                if (typeof tbl_src.attr('cellspacing') !== 'undefined') tbl_dst_html += 'cellspacing="' +tbl_src.attr('cellspacing')+ '"';
                tbl_dst_html += '></table>';

                var tbl_dst = $(tbl_dst_html);
                var sticker = $('<div style="display:none" data-table-sticky-container="1"></div>').insertBefore(tbl_src).append(tbl_dst);
                thead_src.clone().appendTo(tbl_dst);
                sticker.css ({
                    'position': 'absolute',
                    'left': settings.left || tbl_src.offset().left,
                    'z-index': settings.zIndex || 1,
                    'background-color': settings.backgroundColor || "transparent"
                });

                var tr_pairs = [];

                tr_pairs.push({
                    src: $('> thead tr:first', tbl_src),
                    dst: $('> thead tr:first', tbl_dst),
                });

                if ($('> thead tr', tbl_src).length > 1) {
                    tr_pairs.push({
                        src: $('> thead tr:last', tbl_src),
                        dst: $('> thead tr:last', tbl_dst),
                    });
                }

                $(document).on('scroll', function() {
                    var scrollOffset = $(document).scrollTop();

                    if ( (thead_src.offset().top + thead_src.height() < scrollOffset + sticker.height()/2) && (tbl_src.offset().top + tbl_src.height() > scrollOffset + sticker.height()/2)) {
                        sticker.show().stop().animate({
                            'top': settings.offsetTop + scrollOffset,
                        }, 50);
                    } else {
                        sticker.hide();
                    }
                });

                tbl_src.on('content_changed', function() {
                    tbl_dst.css('width', tbl_src.width()+'px')
                    var w = 0;

                    for (var row_num in tr_pairs) {
                        $('th, td', tr_pairs[row_num].src).each(function(i) {
                            w = $(this).width();
//                            $('th:eq('+i+'), td:eq('+i+')', tr_pairs[row_num].src).css('min-width', w+'px');
//                            $('th:eq('+i+'), td:eq('+i+')', tr_pairs[row_num].dst).css('min-width', w+'px');
                            if (!tr_pairs[row_num].src.is(':visible')) tr_pairs[row_num].dst.hide();
                        });
                    }
                });

                $(window).on('resize', function() {
                    tbl_src.trigger('content_changed');
                });

                $(document).trigger('scroll');
                tbl_src.trigger('content_changed');
            }
        });

        return this;
    };

    // public
    $.fn.tableStickyHeader.defaults =
    {
        offsetTop: 0, // offset of table header floating sticker
    };

})(jQuery);
