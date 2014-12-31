define(function() {

    'use strict';

    videojs.options.flash.swf = "/dist/misc/video-js.swf";

    $(document).ready(function($) {

        var title = encodeURIComponent(document.title),
            url   = encodeURI(window.location.href);

        var facebookUrl = 'http://www.facebook.com/sharer.php?u='+url+'&t='+title,
            tuentiUrl   = 'http://www.tuenti.com/?m=Share&func=index&url='+url+'&suggested-text=',
            twitterUrl  = 'https://twitter.com/intent/tweet?url='+url+'&text='+title+'&via=videouri';

        $('#facebook_share').attr('href', facebookUrl);
        $('#tuenti_share').attr('href', tuentiUrl);
        $('#twitter_share').attr('href', twitterUrl);

        $('.popup').click(function(event) {
            var width  = 575,
                height = 400,
                left   = ($(window).width()  - width)  / 2,
                top    = ($(window).height() - height) / 2,
                url    = this.href,
                title  = $(this).attr('id'),
                opts   = 'status=1' +
                       ',width='  + width  +
                       ',height=' + height +
                       ',top='    + top    +
                       ',left='   + left;
          
            window.open(url, title, opts);

            return false;
        });

        (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
        })();
        
        var videoSource = $('#videoPlayer').data('src'),
            videoUrl    = $('#videoPlayer').data('url');

            console.log(videoSource);
            console.log(videoUrl);
            
        videojs('videoPlayer', { "techOrder": [videoSource], "src": videoUrl }).ready(function() {
            // You can use the video.js events even though we use the vimeo controls
            // As you can see here, we change the background to red when the video is paused and set it back when unpaused
            this.on('pause', function() {
                document.body.style.backgroundColor = 'red';
            });

            this.on('play', function() {
                document.body.style.backgroundColor = '';
            });

            // You can also change the video when you want
            // Here we cue a second video once the first is done
            // this.one('ended', function() {
            //     this.src('http://vimeo.com/79380715');
            //     this.play();
            // });
        });
    });
});