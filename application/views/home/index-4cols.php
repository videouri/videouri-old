<br/>
<br/>
<br/>
<section>

    <div id="filter-options" class="row">
        <div class="col-xs-5">
            <div class="btn-group">
                <button class="btn btn-white choosen-source">Source: All</button>
                <button class="btn btn-white dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <span class="dropdown-arrow dropdown-arrow-inverse"></span>
                <ul class="dropdown-menu dropdown-inverse">
                    <li>
                        <a href="#" class="video-source" data-filter="*"> All </a>
                    </li>

                    <?php foreach($apis as $api): ?>
                    <li>
                        <a href="#" class="video-source" data-filter=".<?= $api ?>"> <?= $api ?> </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="col-md-7 text-right">
            <h3 style="color: white; margin: 0; text-shadow: 5px 3px 1px #c0392b">Today's most viewed videos</h3>
        </div>

        <?php if (false): // @TODO ?>
        <div class="col-xs-5 text-right" id="options-block">
            <div class="btn-group">
                <button class="btn btn-white">Sort</button>
                <button class="btn btn-white dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <span class="dropdown-arrow dropdown-arrow-inverse"></span>
                <ul class="dropdown-menu dropdown-inverse">
                    <li>
                        <a href="#" class="video-sort" data-source="popular"> <?= lang('popular_videos') ?> </a>
                    </li>
                    <li>
                        <a href="#" class="video-sort" data-source="top_rated"> <?= lang('toprated_videos') ?> </a>
                    </li>
                    <li>
                        <a href="#" class="video-sort" data-source="most_viewed"> <?= lang('mostviewed_videos') ?> </a>
                    </li>
                </ul>
            </div>

            <div class="btn-group">
                <button class="btn btn-white">Period</button>
                <button class="btn btn-white dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <span class="dropdown-arrow dropdown-arrow-inverse"></span>
                <ul class="dropdown-menu dropdown-inverse">
                    <?php foreach($time as $name => $attr): ?>
                    <li>
                        <a href="#" class="video-period" data-source="<?= $attr ?>"> <?= ucfirst($name) ?> </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div> <!-- Options block -->
        <?php endif; ?>
    </div>

    <div id="video-list" class="row">
    <?php if (!$fakeContent): ?>
    <?php foreach ($data as $sort => $videos):  ?>
        <?php foreach ($videos as $video): ?>

            <div class="col-md-3 col-sm-6 col-xs-12 <?= $sort ?> <?= $video['source'] ?>">
                <div class="tile">
                    <div class="tile-image">
                        <a href="<?= $video['url'] ?>">
                            <img data-original="<?= $video['img'] ?>" alt="<?= $video['title'] ?>" class="lazy-image"
                                 data-toggle="tooltip" data-tooltip-style="light"
                                 title="<?= $video['description'] ?>"/>
                        </a>
                        <span class="fui-play" style="position: absolute; top: 35%; left: 45%; color: #fff; font-size: 30px; text-shadow: 0px 0px 20px #000, 1px -3px 0px #45c8a9" data-url="<?= $video['url'] ?>"></span>
                    </div>
                    <?php if (false): // @TODO ?>
                    <div class="tile-sidebar hidden">
                        <ul class="list-unstyled" style="position: relative;">
                            <li>
                                <button class="close">
                                    <span class="fui-time text-muted"
                                          data-toggle="tooltip" title="5:30"></span>
                                </button>
                            </li>
                            <?php if (isset($video['category'])): ?>
                            <li>
                                <button class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="fui-list text-muted"></span>
                                </button>
                                <span class="dropdown-arrow dropdown-arrow-inverse"></span>
                                <ul class="dropdown-menu dropdown-inverse">
                                    <?php foreach($video['category'] as $category): ?>
                                    <li>
                                        <a href="/category/<?= $category ?>"> <?= $category ?> </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <?php endif ?>
                    
                    <div class="tile-bottom">
                        <span class="source <?= $video['source'] ?>">
                            <?= $video['source'] ?>
                        </span>

                        <h2 class="tile-title">
                            <a href="<?= $video['url'] ?>" title="<?= $video['title'] ?>">
                                <?= $video['title'] ?>
                            </a>
                        </h2>
                    </div>
                </div>

            </div>

            <?php endforeach; //$video ?>
    <?php endforeach; //$sort, $videos ?>
    <?php endif; ?>
    </div>

</section>

<?php
$this->template->scriptCode = <<<EOF
<script type="text/javascript">
    require(['modules/videosListing']);
</script>
EOF;
?>