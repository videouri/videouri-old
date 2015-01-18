<section>

    <div id="filter-options" class="row">
        <div class="col-xs-7">
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

                    <?php foreach ($apis as $api) : ?>
                    <li>
                        <a href="#" class="video-source" data-filter=".<?= $api ?>"> <?= $api ?> </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div id="video-list" class="row">
    <?php foreach ($data as $video): ?>
    <div class="col-md-3 col-sm-6 col-xs-12 <?= $video['source'] ?>">
        <div class="tile">
            <div class="tile-image">
                <a href="<?= $video['url'] ?>">
                    <img data-original="<?= $video['img'] ?>" alt="<?= $video['title'] ?>" class="lazy-image"/>
                </a>
                <span class="fui-play" style="position: absolute; top: 35%; left: 45%; color: #fff; font-size: 30px; text-shadow: 0px 0px 20px #000, 1px -3px 0px #45c8a9" data-url="<?= $video['url'] ?>"></span>
            </div>                        
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
    <?php endforeach; ?>
    </div>

    <div id="page" class="row">
        <div class="col-md-4 col-md-offset-4">
            <ul class="pagination">
                <li class="previous">
                    <a href="#">
                        <i class="fa fa-arrow-left"></i>
                        Previous Page
                    </a>
                </li>
                <li class="next">
                    <a href="#">
                        Next Page
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</section>

<?php
$this->template->scriptCode = <<<EOF
<script type="text/javascript" src="/dist/modules/videosListing.js">
</script>
EOF;
?>