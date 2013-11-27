$('#my-div').hide();

$(document).ready(function() {

    $(document).scroll(function (e) {
        /*console.log(' ');
        console.log('------------------------------------');
        console.log('window.innerHeight: '+window.innerHeight);
        console.log('document.documentElement.clientHeight: '+document.documentElement.clientHeight);
        console.log('document.body.clientHeight: '+document.body.clientHeight);
        console.log('window.pageYOffset: '+window.pageXOffset);
        console.log('document.documentElement.scrollTop: '+document.documentElement.scrollTop);
        console.log('document.body.scrollTop: '+document.body.scrollTop);
        console.log('------------------------------------');
        console.log(' ');*/
        //console.log(document.body.scrollTop);
        //if (document.documentElement.scrollTop >= 140) {
        if( $(this).scrollTop() >= 140 ) {
            $('#my-div').show(200);
        } else {
            $('#my-div').hide(200);
        }
    });

    $('.inputbox').click(function(){
        $('.filter_menu').slideDown();
    });
    $('#search_form').mouseleave(function(){
        $('.filter_menu').slideUp();
    });

    /*function smartColumns() {
        $("ul.panel").css({ 'width' : "100%"});

        var colWrap = $("ul.panel").width();
        var colNum = Math.floor(colWrap / 200);
        var colFixed = Math.floor(colWrap / colNum);

        $("ul.panel").css({ 'width' : colWrap});
        $("ul.panel li").css({ 'width' : colFixed});
    }
    smartColumns();
    $(window).resize(function () {
        smartColumns();
    });*/

    if (($.query.get('page').length == 0) || ($.query.get('page') == 1)) $('.previous').hide();
    else $('.previous').show(); 

    $('.previous').click(function(){
        var cur_page = $.query.get('page');
        if (cur_page.length == 0){ return false; }
        else { var next_page = cur_page - 1; }
        var page = $.query.set('page', next_page).toString();
        window.location.replace(page);
    })
    $('.next').click(function(){        
        var cur_page = $.query.get('page');
        if (cur_page.length == 0){var next_page = cur_page + 2;}
        else { var next_page = cur_page + 1; }
        var page = $.query.set('page', next_page).toString();
        window.location.replace(page);
    })

    $("#shorcuts li a").click(function(){
        $("h1[data-target='" + $(this).data("target") + "']").click();
    });
    $('.top').click(function(){
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        return false;
    });
    $('.bottom').click(function(){
        $("html").animate({ scrollTop: $(document).height() }, "slow");
        return false;
    });

    $('#filter_sources li').find(':checked').each(function() {
       $(this).removeAttr('checked');
    });
    
    $('div.filters_sorts> ul').hide();  
    $('div.filters_sorts> h3').click(function() {
        var $nextDiv = $(this).next();
        var $visibleSiblings = $nextDiv.siblings('div:visible');
     
        if ($visibleSiblings.length ) {
          $visibleSiblings.slideUp('fast', function() {
            $nextDiv.slideToggle('fast');
          });
        } else {
           $nextDiv.slideToggle('fast');
        }
    });

    $('#filter_sources li input:checkbox').change(function() {
        var show = $('input:checkbox:checked').map(function() {
           return $(this).val();
        });
        if (show.length > 0)
        {
            $('#videosList li').each(
            function(){
                //console.log($.inArray($(this).attr('class'),show) );
                /*if ($.inArray($(this).attr('class'),show) == 0)
                {
                    if($(this).attr('class') == 'dailymotion')
                    {
                        list.append(dailymotion_orig);
                    }
                    if($(this).attr('class') == 'metacafe')
                    {
                        list.append(metacafe_orig);
                    }
                    if($(this).attr('class') == 'vimeo')
                    {
                        list.append(vimeo_orig);
                    }
                    if($(this).attr('class') == 'youtube')
                    {
                        list.append(youtube_orig);
                    }
                    $(this).show();
                }
                else*/ if ($.inArray($(this).attr('class'),show) > -1)
                {
                    $(this).show();
                }
                else
                {
                    $(this).hide();
                }
            });
        }
        else
        {
            $('#videosList li').show();
        }
    });

    jQuery.fn.time_from_seconds = function() {
        return this.each(function() {
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
    //$('.duration').time_from_seconds();

    $('#language li a').click(function(){
        var lang = $(this).data('target');
        $.cookie('pref_lang', null);
        $.cookie('pref_lang', lang, { expires: 30, path: '/' });
    });

    $('.family-filter').click(function(){
        if ($.cookie('ff')==null){$.cookie('ff', 'off', { expires: 30, path: '/' });}
        else {$.cookie('ff', null,{ path: '/' })}
    });

    console.log($.cookie('ff'));

    $('img.tile-image').each(function(index, object) {
        console.log($(this).data('src'));
    });

    if($.cookie('source-list')==null) {
        $('a.button[data-source=all]').addClass('selected-title');
    }

    if($.cookie('period-list')==null) {
        $('a.button[data-period=ever]').addClass('selected-title');
    }

    $('#sources-list li').click(function() {
        var method = $('.tabNavigation').find('.selected2').data('method');
        var source = $(this).find('a').data('source');
        var period = $('#periods-list .selected-title').data('period');
        console.log(method + ' ' + period + ' ' + source);
        //$.post('')
    });

    $('#periods-list li').click(function() {
        var method = $('.tabNavigation').find('.selected2').data('method');
        var source = $('#sources-list .selected-title').data('source');
        var period = $(this).find('a').data('period');
        console.log(method + ' ' + period + ' ' + source);
        //$.post('')
    });


    $('.categories').filter(function() {
        if($(this).children("li").length > 1) {
            $(this).each(function(){
                $('li:eq(0)', this).addClass('first-category');
                $('li:gt(0)', this).wrapAll('<ul class="submenu" />');
            });
            $('.submenu').hide();
            $(this).hover(function(){
                $(this).find('.submenu').toggle();
            });
        }
    });

});
