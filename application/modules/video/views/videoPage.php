<div class="vbg">
    <video id="videoPlayer" src="<?= $video['url'] ?>" class="video-js vjs-default-skin vjs-big-play-centered"
           data-src="<?= strtolower($source) ?>" data-url="<?= $video['url'] ?>"
           controls preload="auto" width="100%" height="530">
        <p>Video Playback Not Supported</p>
    </video>
</div>

<div id="video-info">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ul class="video-details list-inline">
                    <li class="video-vuration">
                        <i class="fa fa-clock-o fa-2x"></i>
                        <span>
                            <?= $video['duration'] ?>
                        </span>
                    </li>
                    <li>
                        <span class="separator">
                            |
                        </span> 
                    </li>
                    <li class="video-v-iews">
                        <i class="fa fa-eye fa-2x"></i>
                        <span>
                            <?= $video['views'] ?>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="col-md-6 pull-right text-right">
                <ul class="list-inline">
                    <li>
                        <a href="http://www.facebook.com/sharer.php" class="popup btn-social-facebook" title="Share to Facebook">
                            <i class="fa fa-facebook fa-2x" style="vertical-align: middle"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/share" id="twitter_share" class="popup btn-social-twitter" title="Share to Twitter">
                            <i class="fa fa-twitter fa-2x" style="vertical-align: middle"></i>
                        </a>
                    </li>
                    <li>
                        <div class="addthis_responsive_sharing"></div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <h4 style="letter-spacing: 1px;">
                    <?= $video['title'] ?>
                </h4>
                <br/>

                <div class="description" style="font-size: 12px">
                    <?php
                        $video['description'] = !empty($video['description']) ? $video['description'] : 'No description';
                        // echo parseLinks(nl2br($video['description']));
                        echo nl2br($video['description']);
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <h6>Tags</h6>
                <ul class="tags list-inline">
                    <?php foreach($video['tags'] as $tag): $url = site_url('results?search_query='.$tag.'&action=tag'); ?>
                    <li>
                        <a title="<?= $tag ?>" href="<?= $url ?>">
                            <?= $tag ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <br/>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($video['related'])): ?>
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
        <h4 style="margin-bottom: 0">
            Recommended
        </h4>
        </div>
    </div>
    <hr style="border-color: #c0392b" />
    <div id="related-videos" class="row">
        <?php foreach ($video['related'] as $relatedVideo): ?>
        <div class="col-md-3 col-sm-6 col-xs-12 <?= $relatedVideo['source'] ?>">
            <div class="tile">
                <div class="tile-image">
                    <a href="<?= $relatedVideo['url'] ?>" title="<?= $relatedVideo['title'] ?>">
                        <img src="<?= $relatedVideo['img'] ?>" alt="<?= $relatedVideo['title'] ?>">
                        <!-- <p><?= $relatedVideo['title'] ?></p> -->
                    </a>
                </div>
                <div class="tile-bottom">
                    <h2 class="tile-title">
                        <a href="<?= $relatedVideo['url'] ?>" title="<?= $relatedVideo['title'] ?>">
                            <?= $relatedVideo['title'] ?>
                        </a>
                    </h2>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</div>
<?php endif; ?>

<?php
$this->template->scriptCode = '<script type="text/javascript" src="' . base_url() . '/dist/modules/video.js"></script>';
?>