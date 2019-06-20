/**
 * Resize function without multiple trigger
 * 
 * Usage:
 * $(window).smartresize(function(){  
 *     // code here
 * });
 */
(function ($, sr) {
    // debouncing function from John Hann
    // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
    var debounce = function (func, threshold, execAsap) {
        var timeout;

        return function debounced() {
            var obj = this, args = arguments;
            function delayed() {
                if (!execAsap)
                    func.apply(obj, args);
                timeout = null;
            }

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 100);
        };
    };

    // smartresize 
    jQuery.fn[sr] = function (fn) {
        return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
    };

})(jQuery, 'smartresize');
/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var CURRENT_URL = window.location.href.split('#')[0].split('?')[0],
        $BODY = $('body'),
        $MENU_TOGGLE = $('#menu_toggle'),
        $SIDEBAR_MENU = $('#sidebar-menu'),
        $SIDEBAR_FOOTER = $('.sidebar-footer'),
        $LEFT_COL = $('.left_col'),
        $RIGHT_COL = $('.right_col'),
        $NAV_MENU = $('.nav_menu'),
        $FOOTER = $('footer');



// Sidebar
function init_sidebar() {
// TODO: This is some kind of easy fix, maybe we can improve this
    var setContentHeight = function () {
        // reset height
        $RIGHT_COL.css('min-height', $(window).height());

        var bodyHeight = $BODY.outerHeight(),
                footerHeight = $BODY.hasClass('footer_fixed') ? -10 : $FOOTER.height(),
                leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
                contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;

        // normalize content
        contentHeight -= $NAV_MENU.height() + footerHeight;

        $RIGHT_COL.css('min-height', contentHeight);
    };

    $SIDEBAR_MENU.find('a').on('click', function (ev) {
        console.log('clicked - sidebar_menu');
        var $li = $(this).parent();

        if ($li.is('.active')) {
            $li.removeClass('active active-sm');
            $('ul:first', $li).slideUp(function () {
                setContentHeight();
            });
        } else {
            // prevent closing menu if we are on child menu
            if (!$li.parent().is('.child_menu')) {
                $SIDEBAR_MENU.find('li').removeClass('active active-sm');
                $SIDEBAR_MENU.find('li ul').slideUp();
            } else
            {
                if ($BODY.is(".nav-sm"))
                {
                    $SIDEBAR_MENU.find("li").removeClass("active active-sm");
                    $SIDEBAR_MENU.find("li ul").slideUp();
                }
            }
            $li.addClass('active');

            $('ul:first', $li).slideDown(function () {
                setContentHeight();
            });
        }
    });

// toggle small or large menu 
//    $MENU_TOGGLE.on('click', function () {
//        console.log('clicked - menu toggle');
//
//        if ($BODY.hasClass('nav-md')) {
//            $SIDEBAR_MENU.find('li.active ul').hide();
//            $SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
//        } else {
//            $SIDEBAR_MENU.find('li.active-sm ul').show();
//            $SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
//        }
//
//        $BODY.toggleClass('nav-md nav-sm');
//
//        setContentHeight();
//    });

    // check active menu
    $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');

    $SIDEBAR_MENU.find('a').filter(function () {
        return this.href == CURRENT_URL;
    }).parent('li').addClass('current-page').parents('ul').slideDown(function () {
        setContentHeight();
    }).parent().addClass('active');

    // recompute content when resizing
    $(window).smartresize(function () {
        setContentHeight();
    });

    setContentHeight();

    // fixed sidebar
    if ($.fn.mCustomScrollbar) {
        $('.menu_fixed').mCustomScrollbar({
            autoHideScrollbar: true,
            theme: 'minimal',
            mouseWheel: {preventDefault: true}
        });
    }
}
;
// /Sidebar

var randNum = function () {
    return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
};


// Panel toolbox
$(document).ready(function () {
    $('.collapse-link').on('click', function () {
        var $BOX_PANEL = $(this).closest('.x_panel'),
                $ICON = $(this).find('i'),
                $BOX_CONTENT = $BOX_PANEL.find('.x_content');

        // fix for some div with hardcoded fix class
        if ($BOX_PANEL.attr('style')) {
            $BOX_CONTENT.slideToggle(200, function () {
                $BOX_PANEL.removeAttr('style');
            });
        } else {
            $BOX_CONTENT.slideToggle(200);
            $BOX_PANEL.css('height', 'auto');
        }

        $ICON.toggleClass('fa-chevron-up fa-chevron-down');
    });

    $('.close-link').click(function () {
        var $BOX_PANEL = $(this).closest('.x_panel');

        $BOX_PANEL.remove();
    });
});
// /Panel toolbox

// Tooltip
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });
});
// /Tooltip

// Menu
$(document).ready(function () {
    $(document).on("keydown", function(e) { 
        if ( e.ctrlKey && ( e.which === 32 ) ) {
            if(!$('body').hasClass('modal-open')) {
                $('#menu').ekkoLightbox();
            }
        }
    });
    $(document).on("click", "#menu", function(e) { 
        e.preventDefault();
        if(!$('body').hasClass('modal-open')) {
            $(this).ekkoLightbox();
        }
    });
    $(document).on('keyup', '.menu-search', function () {
        var search = $(this).val().trim().toLowerCase();
        $('.menu-item').removeClass('found-menu-item');
        if (search != '') {
            $('.menu-item').each(function(){
                var itemText = $(this).text().trim().toLowerCase();
                if ( itemText.indexOf(search) != -1) {
                    $(this).addClass('found-menu-item');
                }
            })
        }
    });
});

// /Menu


// Confirmation
$(document).ready(function () {
    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]'
    });
});
// /Confirmation


// Embeded Forms
$(document).ready(function () {
    $(document).on('click', '.remove-embed', function(e){
        e.preventDefault();
        $(this).parent('.embed-group').remove();
    });
    
});
// /Embeded Forms


// Datetime single
$(document).ready(function () {
    $('.datetimepicker').datetimepicker({
        format: 'yyyy-mm-dd hh:ii'
    });
    $('.datepicker').datetimepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        minView: '2'
    });
});
// /Datetimepicker

// File uploading
$(document).on('change', ':file', function () {
    var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

$(document).ready(function () {
    $(':file').on('fileselect', function (event, numFiles, label) {

        var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

        if (input.length) {
            input.val(log);
        }
    });
});
// /File uploading

// Delete image
$('.delete-file').on("click", function () {
    $(this).parent('.file-box').remove();
})
// /Delete image


// Progressbar
if ($(".progress .progress-bar")[0]) {
    $('.progress .progress-bar').progressbar();
}
// /Progressbar

// Switchery
$(document).ready(function () {
    if ($(".js-switch")[0]) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#26B99A'
            });
        });
    }
});
// /Switchery


// iCheck
//$(document).ready(function() {
//    if ($("input.flat")[0]) {
//        $(document).ready(function () {
//            $('input.flat').iCheck({
//                checkboxClass: 'icheckbox_flat-green',
//                radioClass: 'iradio_flat-green'
//            });
//        });
//    }
//});
// $(document).ready(function () {
//     $('input').iCheck({
//         checkboxClass: 'icheckbox_square-aero',
//         radioClass: 'iradio_square-aero',
// //    increaseArea: '20%' // optional
//     });
// });

// /select2
// $(document).ready(function () {
    // $('.select2').select2();
// });
// /select2

// $(document).ready(function () {
//     $(".tablestickyheader").tableStickyHeader({
//         offsetTop: 51,
//         zIndex: 1,
//         left: 1,
//         backgroundColor: '#ffffff80'
//     });
// });


$(document).on('click', '[data-toggle="lightbox"]', function (event) {
    event.preventDefault();

    $(this).ekkoLightbox({
        alwaysShowClose: true,
        onContentLoaded: function () {
//            setTimeout(function () {
//                    $('.lightbox-content .select2').select2();
//            }, 2000);
        }
    });
});

//wide lightbox size 
$(document).ready(function () {
    $('.wide-lightbox').data('width', $(document).width() * 0.8);
    $('.wide-lightbox').data('height', $(document).height() * 0.8);
});

//hover and retain popover when on popover content
var originalLeave = $.fn.popover.Constructor.prototype.leave;
$.fn.popover.Constructor.prototype.leave = function (obj) {
    var self = obj instanceof this.constructor ?
            obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type);
    var container, timeout;

    originalLeave.call(this, obj);

    if (obj.currentTarget) {
        container = $(obj.currentTarget).siblings('.popover');
        timeout = self.timeout;
        container.one('mouseenter', function () {
            //We entered the actual popover – call off the dogs
            clearTimeout(timeout);
            //Let's monitor popover content instead
            container.one('mouseleave', function () {
                $.fn.popover.Constructor.prototype.leave.call(self, self);
            });
        });
    }
};

$('body').popover({
    selector: '[data-popover]',
    trigger: 'click hover',
    delay: {
        show: 50,
        hide: 400
    }
});


function gd(year, month, day) {
    return new Date(year, month - 1, day).getTime();
}


/* STARRR */

function init_starrr() {

    if (typeof (starrr) === 'undefined') {
        return;
    }
    console.log('init_starrr');

    $(".stars").starrr();

    $('.stars-existing').starrr({
        rating: 4
    });

    $('.stars').on('starrr:change', function (e, value) {
        $('.stars-count').html(value);
    });

    $('.stars-existing').on('starrr:change', function (e, value) {
        $('.stars-count-existing').html(value);
    });

}
;


function init_JQVmap() {

    //console.log('check init_JQVmap [' + typeof (VectorCanvas) + '][' + typeof (jQuery.fn.vectorMap) + ']' );	

    if (typeof (jQuery.fn.vectorMap) === 'undefined') {
        return;
    }

    console.log('init_JQVmap');

    if ($('#world-map-gdp').length) {

        $('#world-map-gdp').vectorMap({
            map: 'world_en',
            backgroundColor: null,
            color: '#ffffff',
            hoverOpacity: 0.7,
            selectedColor: '#666666',
            enableZoom: true,
            showTooltip: true,
            values: sample_data,
            scaleColors: ['#E6F2F0', '#149B7E'],
            normalizeFunction: 'polynomial'
        });

    }

    if ($('#usa_map').length) {

        $('#usa_map').vectorMap({
            map: 'usa_en',
            backgroundColor: null,
            color: '#ffffff',
            hoverOpacity: 0.7,
            selectedColor: '#666666',
            enableZoom: true,
            showTooltip: true,
            values: sample_data,
            scaleColors: ['#E6F2F0', '#149B7E'],
            normalizeFunction: 'polynomial'
        });

    }

}
;


function init_skycons() {

    if (typeof (Skycons) === 'undefined') {
        return;
    }
    console.log('init_skycons');

    var icons = new Skycons({
        "color": "#73879C"
    }),
            list = [
                "clear-day", "clear-night", "partly-cloudy-day",
                "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
                "fog"
            ],
            i;

    for (i = list.length; i--; )
        icons.set(list[i], list[i]);

    icons.play();

}

function init_gauge() {

    if (typeof (Gauge) === 'undefined') {
        return;
    }

    console.log('init_gauge [' + $('.gauge-chart').length + ']');

    console.log('init_gauge');


    var chart_gauge_settings = {
        lines: 12,
        angle: 0,
        lineWidth: 0.4,
        pointer: {
            length: 0.75,
            strokeWidth: 0.042,
            color: '#1D212A'
        },
        limitMax: 'false',
        colorStart: '#1ABC9C',
        colorStop: '#1ABC9C',
        strokeColor: '#F0F3F3',
        generateGradient: true
    };


    if ($('#chart_gauge_01').length) {

        var chart_gauge_01_elem = document.getElementById('chart_gauge_01');
        var chart_gauge_01 = new Gauge(chart_gauge_01_elem).setOptions(chart_gauge_settings);

    }


    if ($('#gauge-text').length) {

        chart_gauge_01.maxValue = 6000;
        chart_gauge_01.animationSpeed = 32;
        chart_gauge_01.set(3200);
        chart_gauge_01.setTextField(document.getElementById("gauge-text"));

    }

    if ($('#chart_gauge_02').length) {

        var chart_gauge_02_elem = document.getElementById('chart_gauge_02');
        var chart_gauge_02 = new Gauge(chart_gauge_02_elem).setOptions(chart_gauge_settings);

    }


    if ($('#gauge-text2').length) {

        chart_gauge_02.maxValue = 9000;
        chart_gauge_02.animationSpeed = 32;
        chart_gauge_02.set(2400);
        chart_gauge_02.setTextField(document.getElementById("gauge-text2"));

    }


}

/* AUTOSIZE */

function init_autosize() {

    if (typeof $.fn.autosize !== 'undefined') {

        autosize($('.resizable_textarea'));

    }

}
;

//tags input
function init_TagsInput() {

    if (typeof $.fn.tagsInput !== 'undefined') {

        $('#tags_1').tagsInput({
            width: 'auto'
        });

    }

}
;

/* SELECT2 */

function init_select2() {

//			if( typeof (select2) === 'undefined'){ return; }
//			console.log('init_toolbox');
//			 
//			$(".select2_single").select2({
//			  placeholder: "Select a state",
//			  allowClear: true
//			});
//			$(".select2_group").select2({});
//			$(".select2_multiple").select2({
//			  maximumSelectionLength: 4,
//			  placeholder: "With Max Selection limit 4",
//			  allowClear: true
//			});

}
;

/* WYSIWYG EDITOR */

function init_wysiwyg() {
    if (typeof ($.fn.wysiwyg) === 'undefined') {
        return;
    }
    console.log('init_wysiwyg');

    function init_ToolbarBootstrapBindings() {
        var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'
        ],
                fontTarget = $('[title=Font]').siblings('.dropdown-menu');
        $.each(fonts, function (idx, fontName) {
            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
        });
        $('a[title]').tooltip({
            container: 'body'
        });
        $('.dropdown-menu input').click(function () {
            return false;
        })
                .change(function () {
                    $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
                })
                .keydown('esc', function () {
                    this.value = '';
                    $(this).change();
                });

        $('[data-role=magic-overlay]').each(function () {
            var overlay = $(this),
                    target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
        });

        if ("onwebkitspeechchange" in document.createElement("input")) {
            var editorOffset = $('#editor').offset();

            $('.voiceBtn').css('position', 'absolute').offset({
                top: editorOffset.top,
                left: editorOffset.left + $('#editor').innerWidth() - 35
            });
        } else {
            $('.voiceBtn').hide();
        }
    }

    function showErrorAlert(reason, detail) {
        var msg = '';
        if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
        } else {
            console.log("error uploading file", reason, detail);
        }
        $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
                '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
    }

    $('.editor-wrapper').each(function () {
        var id = $(this).attr('id');	//editor-one

        $(this).wysiwyg({
            toolbarSelector: '[data-target="#' + id + '"]',
            fileUploadError: showErrorAlert
        });
    });


    window.prettyPrint;
    prettyPrint();

}
;


/* COLOR PICKER */

function init_ColorPicker() {

    // if (typeof ($.fn.colorpicker) === 'undefined') {
    //     return;
    // }
    // console.log('init_ColorPicker');
    //
    // $('.demo1').colorpicker();
    // $('.demo2').colorpicker();
    //
    // $('#demo_forceformat').colorpicker({
    //     format: 'rgba',
    //     horizontal: true
    // });
    //
    // $('#demo_forceformat3').colorpicker({
    //     format: 'rgba',
    // });
    //
    // $('.demo-auto').colorpicker();

}
;

/* Notify */
function init_notify() {

    if (typeof ($.notify) === 'undefined') {
        return;
    }

    $.notifyDefaults({
        type: 'success',
        placement: {
            from: "top",
            align: "center"
        },
        animate: {
            enter: 'animated zoomInDown',
            exit: 'animated zoomOutRight'
        }
    });

}
;


function init_popover() {
    $('[data-toggle="popover"]').popover({
        container: 'body',
        html: true,
        trigger: 'hover',
        content: function () {
            var url = $(this).data('full');
            return '<img src="' + url + '">'
        }
    });
}

$(document).ready(function () {
    init_sidebar();
    init_wysiwyg();
    init_JQVmap();
    init_ColorPicker();
    init_TagsInput();
    init_skycons();
    init_select2();
    init_gauge();
    init_notify();
    init_starrr();
    init_autosize();
    init_popover();
});


