<br/>

<div class="row">
    <div class="col-md-8">
        <div class="vbg">
            <video id="videoPlayer" src="<?= $video['url'] ?>" class="video-js vjs-default-skin"
                   data-src="<?= strtolower($source) ?>" data-url="<?= $video['url'] ?>"
                   controls preload="auto" width="100%" height="360">
                <p>Video Playback Not Supported</p>
            </video>
        </div>
        <div class="info">
            <h1 style="color: white; margin: 0; text-shadow: 3px 2px 1px #c0392b; font-size: 38px"><?= $video['title'] ?></h1>
            <div class="share">
                <ul class="list-inline right">
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
            <!--<div class="category"><strong>Category:</strong><h2><?#=$video['category'] ?></h2></div>-->
            <div class="tags">
                <strong>Tags:</strong>
                <ul class="bootstrap-tagsinput">
                <?php foreach($video['tags'] as $tag): $url=site_url('results?search_query='.$tag.'&action=tag'); ?>
                <li class="tag label label-danger">
                    <a title="<?= $tag ?>" href="<?= $url ?>">
                        <?= $tag ?>
                    </a>
                </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <br/>

            <div class="description">
                <strong>Description:</strong><hr>
                <p>
                    <?php $video['description'] = !empty($video['description']) ? $video['description'] : 'No description' ; echo $video['description']; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
    <?php if (!empty($video['related'])): ?>
        <h2>Suggested Videos:</h2><br/>
        <!--<ul id="nav">
            <?php foreach($video['related'] as $key=>$value): ?>
            <li><a href="#<?= $key ?>"><?= $key ?></a></li>
            <?php endforeach; ?>
        </ul>-->

        <?php foreach ($video['related'] as $key => $value): ?>
        <ul id="<?= $key ?>" class="related">
            <?php foreach ($value as $api): ?>
            <li>
                <a href="<?= $api['url'] ?>" title="<?= $api['title'] ?>">
                    <img src="<?= $api['img'] ?>" alt="<?= $api['title'] ?>" width="80" height="60">
                    <p><?= $api['title'] ?></p>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endforeach; ?>
        <div class="clearfix"></div>
    <?php endif; ?>
    </div>
</div>

<?php
$this->template->scriptCode = <<<EOF
<script type="text/javascript" src="/dist/modules/video.js"></script>
EOF;
?>