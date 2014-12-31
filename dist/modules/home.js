require(function() {

    'use strict';

    $(document).ready(function() {
        // var amount = Math.floor($(document).width() / 186) + 2;
        // $('#home-page-featured .featured-list').each(function(){
        //     for (var i = 0; i < amount; i++) {
        //         $(this).append(
        //             '<li>'
        //                 +'<a href="/"><img width="186" height="186" src="/assets/img/blank.jpg" /></a>'
        //             +'</li>'
        //         );
        //     }
        // });

        // $.ajax({
        //     url          : '/api/videos',
        //     data         : {
        //         //'amount': (amount * 2),
        //         'sort'  : 'top_rated',
        //         'period': 'today',
        //         'source': 'all'
        //     },
        //     type         : 'GET',
        //     dataType     : 'json',

        //     localCache   : true,
        //     cacheTTL     : 12,

        //     success: function(reply, textStatus, jqXHR) {
        //         var projects = [];
        //         var container = $('ul.featured-list');
        //         $.each(reply, function(index, value) {
        //             if(value.gallery)
        //             {
        //                 image = value.gallery;
        //                 //  data-categories="'+value['categories']+'"
        //                 projects.push(
        //                     '<a href="<?= SRC_URL ?>/project/'+value['id']+'" class="project-pan" title="'+value['name']+'" data-description="'+value['description']+'">'
        //                         +'<img width="186" height="186" src="<?= SRC_URL ?>/data/images/'+image.name+'" />'
        //                     +'</a>'
        //                 );
        //             }
        //         });

        //         $('ul.featured-list').each(function() {  
        //             $(this).find('li').each(function() {
        //                 $(this).addClass('project').html(projects.shift());
        //             });
        //         });
        //     },
        //     fail: function(jqXHR, textStatus, errorThrown) {
        //         console.log(jqXHR);
        //         console.log(textStatus);
        //         console.log(errorThrown);
        //     }
        // });

        // $('.tile-image').hover(function() {
        //     $(this).closest('tile-sidebar').fadeIn('fast');
        // });
    });
});