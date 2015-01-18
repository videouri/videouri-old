// define(['jquery', 'isotope', 'jquery.bridget'], function($, Isotope) {

    'use strict';

    // $.bridget('isotope', Isotope);

    var $isotopeContainer,
        page, curPage, nextPage;

    $(document).ready(function() {

        /**
         * Lazy loading for images
         */
        $('img.lazy-image').lazyload();

        /**
         * Isotope plugin
         */
        $isotopeContainer = $('#video-list').isotope({
            itemSelector: '.col-md-3',
            layoutMode: 'masonry'
        });

        // filter items on button click
        $('.video-source').on('click', function() {
            var filterValue = $(this).data('filter');
            $('.choosen-source').html('Source: '  + $(this).text());
            $isotopeContainer.isotope({ filter: filterValue });
        });


        $('.pagination .previous').click(function () {
            curPage = $.query.get('page');
            console.log(curPage + 'previous')

            if (curPage.length === 0) {
                return false;
            }
            else {
                nextPage = curPage - 1;
            }

            page = $.query.set('page', nextPage).toString();
            window.location.replace(page);
        });

        $('.pagination .next').click(function () {
            curPage = $.query.get('page');
            console.log(curPage + 'next')

            if (curPage.length === 0) {
                nextPage = curPage + 2;
            }
            else {
                nextPage = curPage + 1;
            }

            page = $.query.set('page', nextPage).toString();
            window.location.replace(page);
        });

    });
// });