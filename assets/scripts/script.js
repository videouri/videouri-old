(function ($, window, document, undefined) {
    
    'use strict';

    $(function () {

        $(document).scroll(function() {
            /*if ($(this).scrollTop() >= 140 ) {
                $('header.navbar').removeClass('hidden');
            } else {
                $('header.navbar').addClass('hidden');
            }*/
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

        var amount = Math.floor($(document).width() / 186) + 2;
        /*$('#home-page-featured .featured-list').each(function(){
            for (var i = 0; i < amount; i++) {
                $(this).append(
                    '<li>'
                        +'<a href="<?= SRC_URL ?>"><img width="186" height="186" src="<?=  SRC_URL; ?>/assets/img/blank.jpg" /></a>'
                    +'</li>'
                );
            }
        });*/

        $.ajax({
            url          : '/api/videos',
            data         : {
                //'amount': (amount * 2),
                'sort'  : 'top-rated',
                'period': 'today',
                'source': 'all'
            },
            type         : 'GET',
            dataType     : 'json',

            localCache   : true,
            cacheTTL     : 12,

            success: function(reply, textStatus, jqXHR) {
                var projects = [];
                var container = $('ul.featured-list');
                $.each(reply, function(index, value) {
                    if(value.gallery)
                    {
                        image = value.gallery;
                        //  data-categories="'+value['categories']+'"
                        projects.push(
                            '<a href="<?= SRC_URL ?>/project/'+value['id']+'" class="project-pan" title="'+value['name']+'" data-description="'+value['description']+'">'
                                +'<img width="186" height="186" src="<?= SRC_URL ?>/data/images/'+image.name+'" />'
                            +'</a>'
                        );
                    }
                });

                $('ul.featured-list').each(function() {  
                    $(this).find('li').each(function() {
                        $(this).addClass('project').html(projects.shift());
                    });
                });
            },
            fail: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });

        if (($.query.get('page').length === 0) || ($.query.get('page') === 1)) {
            $('.previous').hide();  
        } else { 
            $('.previous').show(); 
        }

        var page, curPage, nextPage;

        $('.previous').click(function(){
            curPage = $.query.get('page');

            if (curPage.length === 0) {
                return false;
            }
            else {
                nextPage = curPage - 1;
            }

            page = $.query.set('page', nextPage).toString();
            window.location.replace(page);
        });

        $('.next').click(function(){        
            curPage = $.query.get('page');
            if (curPage.length === 0) {
                nextPage = curPage + 2;
            }
            else {
                nextPage = curPage + 1;
            }

            page = $.query.set('page', nextPage).toString();
            window.location.replace(page);
        });

        $('#shorcuts li a').click(function(){
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

            if (show.length > 0) {
                $('#videosList li').each(function() {
                    //console.log($.inArray($(this).attr('class'),show) );
                    /*if ($.inArray($(this).attr('class'),show) === 0)
                    {
                        if($(this).attr('class') === 'dailymotion')
                        {
                            list.append(dailymotion_orig);
                        }
                        if($(this).attr('class') === 'metacafe')
                        {
                            list.append(metacafe_orig);
                        }
                        if($(this).attr('class') === 'vimeo')
                        {
                            list.append(vimeo_orig);
                        }
                        if($(this).attr('class') === 'youtube')
                        {
                            list.append(youtube_orig);
                        }
                        $(this).show();
                    }
                    else*/
                    if ($.inArray($(this).attr('class'),show) > -1) {
                        $(this).show();
                    }
                    else {
                        $(this).hide();
                    }
                });
            }
            else {
                $('#videosList li').show();
            }
        });

        jQuery.fn.timeFromSeconds = function() {
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
            if ($.cookie('ff') === null) {
                $.cookie('ff', 'off', { expires: 30, path: '/' });
            }
            else {
                $.cookie('ff', null,{ path: '/' });
            }
        });

        //console.log($.cookie('ff'));

        /**
         * Lazy loading for images
         */
        $('img.lazy-image').lazyload();

        if($.cookie('source-list')===null) {
            $('a.button[data-source=all]').addClass('selected-title');
        }

        if($.cookie('period-list')===null) {
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

})(jQuery, window, document);