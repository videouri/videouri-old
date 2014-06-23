<section id="home">

    <div id="left-block">
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


    <div class="row">
        <ul class="tabNavigation">
            <!--<li><a href="#popular"><?#=lang('popular_videos') ?></a></li>-->
            <li class="selected1" data-method="top_rated"><a href="#top_rated"><?= lang('toprated_videos') ?></a></li>
            <li><a href="#most_viewed" data-method="most_viewed"><?= lang('mostviewed_videos') ?></a></li>
        </ul>
    </div>

    <div class="row">
        <div id="options-block">
            <nav id="sources-block">
                <h2 class="title">Select source</h2>
                <ul id="sources-list">
                    <li>
                        <a class="button" data-source="all">
                            <span class="margin-button"></span>
                            All
                        </a>
                    </li>
                    <?php foreach($apis as $api): ?>
                    <li>
                        <a class="button" data-source="<?= $api ?>">
                            <span class="margin-button"></span>
                            <?= $api ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <nav id="periods-block">
                <h2 class="title">Select When</h2>
                <ul id="periods-list">
                    <?php foreach($time as $name => $attr): ?>
                    <li>
                        <a class="button" data-period="<?= $attr ?>">
                            <span class="margin-button"></span>
                            <?= ucfirst($name) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div> <!-- Options block -->
    </div>

    <?php foreach ($data as $sort => $sortData): ?>
        <?php foreach ($sortData as $api => $apiData): ?>
            <?php $videosCount = count($apiData); $i = 1; foreach ($apiData as $video): ?>

            <?php if ($i == 1): ?>
            <div class="row">
            <?php endif; ?>

                <div class="col-md-4 col-sm-6 col-xs-12 <?= $sort ?> <?= $api ?>">
                    <div class="tile">
                        <div class="tile-image">
                            <img data-original="<?= $video['img'] ?>" alt="<?= $video['title'] ?>" class="lazy-image"
                                 data-toggle="tooltip" data-tooltip-style="light"
                                 title="<?= $video['description'] ?>"/>
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
                        <div class="tile-title <?= $api ?>" style="height: 40px; text-align: center;">
                            <h2 class="title" style="font-size: 12px; margin: 0 auto; display:inline-block; vertical-align:middle">
                                <a href="<?= $video['url'] ?>" title="<?= $video['title'] ?>">
                                    <?= $video['title'] ?>
                                </a>
                            </h2>
                        </div>
                    </div>
                    <br/>

                </div>

            <?php if ($i == $videosCount): ?>
            </div>
            <?php endif; ?>

            <?php $i++; endforeach; //$video ?>
        <?php endforeach;  //$api, $apiData ?>
    <?php endforeach; //$sort, $sortData ?>


</section>