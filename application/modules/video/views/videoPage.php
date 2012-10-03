<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {FB.init({ appId : '277719198954055', channelUrl : '//www.videouri.com/channel.html', status : true, cookie : true, xfbml : true });};
  (function(d){
     var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     d.getElementsByTagName('head')[0].appendChild(js);
   }(document));
</script>
<section id="videoPage">  
	<div class="section_header">
		<h1><?=$data['title'];?></h1>
	</div>
	<div id="content">
		<div class="left" id="video_data">
      <div class="vbg">
        <div id="videoPlayer"><?php echo isset($data['embed_html']) ? $data['embed_html'] : null; ?></div>
      </div>
      <div class="info">
        <div class="share">
          <div class="left">
          </div>
          <ul class="right">
            <li>
              <a href="http://www.facebook.com/sharer.php" id="facebook_share" class="popup" title="Share to Facebook"></a>
            </li>
            <li>
              <a href="https://twitter.com/share" id="twitter_share" class="popup" title="Share to Twitter"></a>
            </li>
            <li>
              <a href="http://www.tuenti.com/share" id="tuenti_share" class="popup" title="Share to Tuenti"></a>
            </li>
            <li>
              <div class="g-plusone" data-annotation="none" data-size="standard"></div>
            </li>
            <li>
              <a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pubid=ra-4f2476ee695f238a">
                <img src="http://s7.addthis.com/static/btn/sm-share-en.gif" width="83" height="16" alt="Bookmark and Share" style="border:0"/>
              </a>
            </li>
          </ul>
        </div>
        <div class="clearfix"></div>
        <!--<div class="category"><strong>Category:</strong><h2><?#=$data['category'];?></h2></div>-->
        <div class="tags">
          <strong>Tags:</strong><hr>
          <?php foreach($data['tags'] as $tag): $url=site_url('results?search_query='.$tag.'&action=tag'); ?>
          <ul class="tags"><li><a title="<?=$tag;?>" href="<?=$url;?>"><?=$tag;?></a></li></ul>
          <?php endforeach; ?>
        </div><br/>
        <div class="description">
          <strong>Description:</strong><hr>
          <p>
            <?php $data['description'] = !empty($data['description']) ? $data['description'] : 'No description' ; echo $data['description']; ?>
          </p>
        </div>
      </div>
		</div>
		<div class="right" id="video_sidebar">
      <?php if(!empty($data['related'])): ?>
      <h2>Suggested Videos:</h2><br/>
      <!--<ul id="nav">
        <?php foreach($data['related'] as $key=>$value): ?>
        <li><a href="#<?=$key;?>"><?=$key;?></a></li>
        <?php endforeach; ?>
      </ul>-->

      <?php foreach($data['related'] as $key=>$value): ?>
      <ul id="<?=$key;?>" class="related">
        <?php foreach($value as $api): ?>
        <li>
          <a href="<?=$api['url'];?>" title="<?=$api['title'];?>">
            <img src="<?=$api['img'];?>" alt="<?=$api['title'];?>" width="80" height="60">
            <p><?=$api['title'];?></p>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endforeach; ?>
      <div class="clearfix"></div>
      <?php endif; ?>
		</div>
	</div>
	<center>
		<div id="respond"><h3><?=lang('leave_comment');?></h3></div>
		<div id="fbcomments"></div>
	</center>
</section>
<script src="<?=base_url();?>assets/js/libs/swfobject.js"></script>
<script src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f2476ee695f238a"></script>
<script>
$(document).ready(function() {

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
    }
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

    function fbcomments(){
      var width = $('#respond').width();
      var fbxml = '<fb:comments href="<?=current_url();?>" num_posts="30" width="'+width+'px"></fb:comments>';
      $('#fbcomments').append(fbxml);
    };
    fbcomments();

    <?php if(isset($data['swf'])) : ?>
      var playerHeight = 360;
      var flashvars = { autoplay: "false" }
      var params = { play: "false", menu: "true", swliveconnect: "true", allowfullscreen: "always", allowscriptaccess: "true", allowscriptaccess: "all" };
      //var params = { allowScriptAccess: "always" };
      var attributes = { id: "<?=$data['swf']['api'];?>" };

      //swfobject.switchOffAutoHideShow();
      //swfobject.embedSWF("http://www.youtube.com/v/8jR7Sg6UCzM?enablejsapi=1&playerapiid=ytplayer&version=3", "videoPlayer", "300", "120", "9.0.0", null, null, params, attributes);

      //alert("<?=$data['swf']['url'];?>");
      swfobject.embedSWF("<?=$data['swf']['url'];?>", "videoPlayer", "100%", playerHeight, "9.0.0", "<?=base_url();?>assets/js/libs/swfobject/expressInstall.swf", flashvars, params, attributes);    
    <?php endif; ?>
});
</script>