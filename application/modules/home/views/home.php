<header id="home-header" class="row">
    <!-- content to be placed inside <body>…</body> -->
    <div class='row row-hexagon'>
        <div class='hexagon'></div>
    </div>
    <div class='row row-hexagon'>
        <div class='hexagon content ribbon' data-content='This is a test!!! 9/10'></div>
        <div class='hexagon content ribbon' data-content='Some longer text here. Bla bla'></div>
    </div>
    <div class='row row-hexagon'>
        <div class='hexagon logo'></div>
    </div>

    <div id="top-hex-menu" class="hidden">
        <div class="col-xs-6">
            <div class="hex hex-1 hex-gap">
                <div class="inner">
                        <h4>HOME</h4>
                        <hr>
                        <p>Home Sweet Home</p>
                </div>
                <a href="#"></a>
                <div class="corner-1"></div>
                <div class="corner-2"></div>
            </div>

            <div class="hex hex-2">
                <div class="inner">
                        <h4>HOME</h4>
                        <hr>
                        <p>Home Sweet Home</p>
                </div>
                <a href="#"></a>
                <div class="corner-1"></div>
                <div class="corner-2"></div>
            </div>

            <div class="hex hex-3">
                <div class="inner">
                        <h4>HOME</h4>
                        <hr>
                        <p>Home Sweet Home</p>
                </div>
                <a href="#"></a>
                <div class="corner-1"></div>
                <div class="corner-2"></div>
            </div>

            <div class="hex hex-3">
                <div class="inner">
                        <h4>HOME</h4>
                        <hr>
                        <p>Home Sweet Home</p>
                </div>
                <a href="#"></a>
                <div class="corner-1"></div>
                <div class="corner-2"></div>
            </div>
            
            <div class="hex hex-3">
                <div class="inner">
                        <h4>HOME</h4>
                        <hr>
                        <p>Home Sweet Home</p>
                </div>
                <a href="#"></a>
                <div class="corner-1"></div>
                <div class="corner-2"></div>
            </div>
            
            <div class="hex hex-3 hex-gap">
                <div class="inner">
                        <h4>HOME</h4>
                        <hr>
                        <p>Home Sweet Home</p>
                </div>
                <a href="#"></a>
                <div class="corner-1"></div>
                <div class="corner-2"></div>
            </div>

            <div class="hex hex-3">
                <div class="inner">
                        <h4>HOME</h4>
                        <hr>
                        <p>Home Sweet Home</p>
                </div>
                <a href="#"></a>
                <div class="corner-1"></div>
                <div class="corner-2"></div>
            </div>
        </div>
    </div>
</header>

<div class="clearfix"></div>

<section id="home">

        <div id="left-block" style="display:none;">
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

    <div class="row">
        <?php foreach ($data as $keySection => $valueSection): ?>
        <div class="videos-list <?=  $keySection ?>">

            <?php foreach ($valueSection as $keyApi => $valueApi): ?>            
                <?php foreach ($valueApi as $video): ?>
                <div class="col-md-3 <?= $keyApi ?>">

                    <div class="tile">
                        <div class="tile-image">
                            <div class="image-sidebar hidden">
                                <ul class="list-unstyled" style="position: relative;">
                                    <li>
                                        <a href="#categories" class="dropdown-toggle" data-toggle="dropdown">
                                            <span class="fui-list"></span>
                                        </a>
                                        <span class="dropdown-arrow" style=""></span>
                                        <ul class="dropdown-menu">
                                            <?php foreach($video['category'] as $category): ?>
                                            <li>
                                                <a href="/category/<?= $category ?>"> <?= $category ?> </a>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <img data-original="<?= $video['img'] ?>" alt="<?= $video['title'] ?>" class="lazy-image" />
                            <span class="fui-play" style="position: absolute; top: 40%; color: #fff; font-size: 30px; text-shadow: 0px 0px 20px #000, 1px -3px 0px #45c8a9" data-url="<?= $video['url'] ?>"></span>
                        </div>
                        <div class="tile-title <?= $keyApi ?>">
                            <h2 class="title" style="font-size: 12px; margin: 0">
                                <a href="<?= $video['url'] ?>" title="<?= $video['title'] ?>">
                                    <?= $video['title'] ?>
                                </a>
                            </h2>
                        </div>
                        <p class="hidden"><?= $video['description'] ?></p>
                    </div>
                    <br/>

                </div>
                <?php endforeach; //$video ?>
            <?php endforeach;  //$keyApi, $valueApi ?>

        </div>

        <?php endforeach; //$keySection, $valueSection ?>

    </div>

</section>