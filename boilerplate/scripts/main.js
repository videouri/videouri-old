$.fn.timeFromSeconds = function () {
    return this.each(function () {
        var t = parseInt($(this).text(), 10);
        $(this).data('original', t);
        var h = Math.floor(t / 3600);
        t %= 3600;
        var m = Math.floor(t / 60);
        var s = Math.floor(t % 60);
        $(this).text((h > 0 ? h + ':' : '') +
                     (m > 0 ? ((m < 10) ? '0'+m : m) + ':' : '00:') +
                     ((s < 10) ? '0'+s : s) );
    });
};

$(function () {

    $('.input-group').on('focus', '.form-control', function () {
        $(this).closest('.input-group, .form-group').addClass('focus');
    }).on('blur', '.form-control', function () {
        $(this).closest('.input-group, .form-group').removeClass('focus');
    });

    //$('.duration').time_from_seconds();

    $('.family-filter').click(function () {
        if ($.cookie('ff') === null) {
            $.cookie('ff', 'off', { expires: 30, path: '/' });
        }
        else {
            $.cookie('ff', null,{ path: '/' });
        }
    });

    if ($.cookie('source-list') === null) {
        $('a.button[data-source=all]').addClass('selected-title');
    }

    if ($.cookie('period-list') === null) {
        $('a.button[data-period=ever]').addClass('selected-title');
    }

    // $('#sources-list li').click(function () {
    //     var method = $('.tabNavigation').find('.selected2').data('method');
    //     var source = $(this).find('a').data('source');
    //     var period = $('#periods-list .selected-title').data('period');
    //     console.log(method + ' ' + period + ' ' + source);
    //     //$.post('')
    // });

    // $('#periods-list li').click(function () {
    //     var method = $('.tabNavigation').find('.selected2').data('method');
    //     var source = $('#sources-list .selected-title').data('source');
    //     var period = $(this).find('a').data('period');
    //     console.log(method + ' ' + period + ' ' + source);
    //     //$.post('')
    // });

    // $('.categories').filter(function () {
    //     if ($(this).children("li").length > 1) {
    //         $(this).each(function (){
    //             $('li:eq(0)', this).addClass('first-category');
    //             $('li:gt(0)', this).wrapAll('<ul class="submenu" />');
    //         });

    //         $('.submenu').hide();

    //         $(this).hover(function (){
    //             $(this).find('.submenu').toggle();
    //         });
    //     }
    // });

});