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
            <div class="<?= $keyApi ?>">

                <?php foreach ($valueApi as $api): ?>
                <div class="col-md-3 <?= $keyApi ?>">

                    <div class="tile">
                        <div class="tile-image">
                            <i class="fa fa-spinner fa-3x fa-spin" data-src="<?= $api['img'] ?>"></i>
                            <a href="<?= $api['url'] ?>" title="<?= $api['title'] ?>" class="hidden">
                                <img data-src="<?= $api['img'] ?>" class="tile-image" />
                            </a>
                        </div>
                        <div class="tile-title <?= $keyApi ?>">
                            <span>
                                <?= $keyApi ?>
                            </span>
                            <select class="video-category">
                                <?php foreach($api['category'] as $category): ?>
                                <option value="<?= $category ?>"> <?= $category ?> </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="clearfix"></div>
                        </div>
                        <h2 class="title" style="font-size: 12px">
                            <a href="<?= $api['url'] ?>" title="<?= $api['title'] ?>"><?= $api['title'] ?></a>
                        </h2>
                        <p><?= $api['description'] ?></p>
                    </div>

                </div>
                <?php endforeach; //$api ?>

            </div>
            <?php endforeach;  //$keyApi, $valueApi ?>

        </div>

        <?php endforeach; //$keySection, $valueSection ?>

    </div>

</section>