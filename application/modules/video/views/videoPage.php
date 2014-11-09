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
                    <div class="left"></div>
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
<script>
    <?php
        $count = count($data['tags']);
        $hashtags = $count == 0 ? 'videouri' : implode(', ', array_slice($data['tags'], 0,min(1,$count))).',videouri';
    ?>

    var video = {
        'id'      : "<?= $data['swf']['api'] ?>",
        'swfUrl'  : "<?= $data['swf']['url'] ?>",
        'hashtags': "<?= $hashtags ?>" 
    };
</script>