.jQuery(document).ready(function($) {
    function social_share()
    {
        var title = encodeURIComponent(document.title);
        url = encodeURI(window.location.href);
        console.log(url);

        <?php
        $count = count($data['tags']);
        $hashtags = $count == 0 ? 'videouri' : implode(', ', array_slice($data['tags'], 0,min(1,$count))).',videouri';
        ?>
        //var hashtags = '<?=$hashtags;?>';

        var facebook_link = 'http://www.facebook.com/sharer.php?u='+url+'&t='+title;
        var tuenti_link = 'http://www.tuenti.com/?m=Share&func=index&url='+url+'&suggested-text=';
        //var twitter_link = 'https://twitter.com/intent/tweet?url='+url+'&text='+title+'&via=videouri&hashtags='+hashtags;
        var twitter_link = 'https://twitter.com/intent/tweet?url='+url+'&text='+title+'&via=videouri';
        $('#facebook_share').attr('href', facebook_link);
        $('#tuenti_share').attr('href', tuenti_link);
        $('#twitter_share').attr('href', twitter_link);
    };
    social_share();

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

    function fbcomments()
    {
        var width = $('#respond').width();
        var fbxml = '<fb:comments href="<?=current_url();?>" num_posts="30" width="'+width+'px"></fb:comments>';
        $('#fbcomments').append(fbxml);
    };
    fbcomments();

    var playerHeight = 360,
        flashvars = {autoplay: "false"},
        params = {
                play: "false", menu: "true", swliveconnect: "true", allowfullscreen: "always",
                allowscriptaccess: "true", allowscriptaccess: "all"
            },
        attributes = {id: "<?=$data['swf']['api'];?>"};

    //swfobject.switchOffAutoHideShow();
    //swfobject.embedSWF("http://www.youtube.com/v/8jR7Sg6UCzM?enablejsapi=1&playerapiid=ytplayer&version=3", "videoPlayer", "300", "120", "9.0.0", null, null, params, attributes);

    //alert("<?=$data['swf']['url'];?>");
    swfobject.embedSWF("<?=$data['swf']['url'];?>", "videoPlayer", "100%", playerHeight, "9.0.0", "<?=base_url();?>assets/js/libs/swfobject/expressInstall.swf", flashvars, params, attributes);    
});