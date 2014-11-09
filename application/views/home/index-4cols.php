<section>

    <div id="left-block" class="hidden">
        <div id="categories-block">
            <h2 class="title">Categories</h2>
            <ul class="categories-list">
                <li><a data-category="news">News</a></li>
                <li><a data-category="comedy">Comedy</a></li>
                <li><a data-category="movies">Movies</a></li>
                <li><a data-category="sports">Sports</a></li>
            </ul>
        </div>
    </div>


    <div id="options" class="row">
        <div class="col-xs-7">
            <div class="btn-group">
                <button class="btn btn-default">Source</button>
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <span class="dropdown-arrow dropdown-arrow-inverse"></span>
                <ul class="dropdown-menu dropdown-inverse">
                    <li>
                        <a href="#" class="video-source" data-source="all"> All </a>
                    </li>

                    <?php foreach($apis as $api): ?>
                    <li>
                        <a href="#" class="video-source" data-source="<?= strtolower($api) ?>"> <?= $api ?> </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="col-xs-5 text-right" id="options-block">
            <!-- Video sorting -->
            <div class="btn-group">
                <button class="btn btn-default">Sort</button>
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
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

            <!-- Video period -->
            <div class="btn-group">
                <button class="btn btn-default">Period</button>
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
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
    </div>

    <div id="video-list" class="row">
    <?php if (!$fakeContent): ?>
    <?php foreach ($data as $sort => $sortData): ?>
        <?php foreach ($sortData as $api => $apiData): ?>
            <?php $videosCount = count($apiData); $i = 1; foreach ($apiData as $video): ?>

            <?php if ($i == 1): ?>
            <?php endif; ?>

                <div class="col-md-3 col-sm-6 col-xs-12 <?= $sort ?> <?= $api ?>">
                    <div class="tile">
                        <div class="tile-image">
                            <a href="<?= $video['url'] ?>">
                                <img data-original="<?= $video['img'] ?>" alt="<?= $video['title'] ?>" class="lazy-image"
                                     data-toggle="tooltip" data-tooltip-style="light"
                                     title="<?= $video['description'] ?>"/>
                            </a>
                            <span class="fui-play" style="position: absolute; top: 35%; left: 45%; color: #fff; font-size: 30px; text-shadow: 0px 0px 20px #000, 1px -3px 0px #45c8a9" data-url="<?= $video['url'] ?>"></span>
                        </div>                        
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
                        
                        <div class="tile-bottom">
                            <span class="source <?= $api ?>">
                                <?= $api ?>
                            </span>

                            <h2 class="tile-title">
                                <a href="<?= $video['url'] ?>" title="<?= $video['title'] ?>">
                                    <?= $video['title'] ?>
                                </a>
                            </h2>
                        </div>
                    </div>

                </div>

            <?php if ($i == $videosCount): ?>
            <?php endif; ?>

            <?php $i++; endforeach; //$video ?>
        <?php endforeach;  //$api, $apiData ?>
    <?php endforeach; //$sort, $sortData ?>
    <?php endif; ?>
    </div>

</section>