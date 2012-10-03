<section id="home">

    <div class="container" data-easytabs="true">

        <ul class="tabNavigation">
            <!--<li><a href="#popular"><?#=lang('popular_videos');?></a></li>-->
            <li class="selected2" data-method="top_rated"><a href="#top_rated"><?=lang('toprated_videos');?></a></li>
            <li><a href="#most_viewed" data-method="most_viewed"><?=lang('mostviewed_videos');?></a></li>
        </ul>

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

        <div id="right-block">

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
                            <a class="button" data-source="<?=$api;?>">
                                <span class="margin-button"></span>
                                <?=$api;?>
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
                            <a class="button" data-period="<?=$attr;?>">
                                <span class="margin-button"></span>
                                <?=ucfirst($name);?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div> <!-- Options block -->

            <hr/>

            <div class="clearfix"></div>


            <?php foreach($data as $keySection=>$valueSection): ?>
            <div id="videos-list" class="<?=$keySection;?>">

                <?php foreach($valueSection as $keyApi=>$valueApi): ?>            
                <div id="<?=$keyApi;?>">

                    <?php foreach($valueApi as $api): ?>
                    <div class="column <?=$keyApi;?>">

                        <div class="block">
                            <div class="top">
                                <?php
                                    switch($keyApi)
                                    {
                                        case 'youtube':
                                            $source = '<span style="color:white">You</span><span style="color:black">Tube</span>';
                                        break;
                                        case 'vimeo':
                                            $source = 'Vimeo';
                                        break;
                                        case 'dailymotion':
                                            $source = 'Dailymotion';
                                        break;
                                        case 'metacafe':
                                            $source = 'Metacafe';
                                        break;
                                    }
                                ?>
                                <span class="<?=$keyApi;?>"><?=$source;?></span>
                                <span class="right">
                                    <ul class="categories">
                                        <?php foreach($api['category'] as $category): ?>
                                        <li><?=$category;?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </span>
                            </div>
                            <div class="middle">
                                <a href="<?=$api['url'];?>" title="<?=$api['title'];?>">
                                    <img src="<?=$api['img'];?>" alt="<?=$api['title'];?>">
                                </a>
                                <h2 class="title">
                                    <a href="<?=$api['url'];?>" title="<?=$api['title'];?>"><?=$api['title'];?></a>
                                </h2>
                                <p><?=$api['description'];?></p>
                            </div>
                        </div>

                    </div>
                    <?php endforeach; //$api ?>

                </div>
                <?php endforeach;  //$keyApi, $valueApi ?>

            </div>

            <?php endforeach; //$keySection, $valueSection ?>

        </div> <!-- Middle block -->

    </div>

    <div class="clearfix"></div>

</section>

<div id="introduction">
    <?=lang('what_is');?>
</div>

<script>
    $(function(){

        if($.cookie('source-list')==null) {
            $('a.button[data-source=all]').addClass('selected-title');
        }

        if($.cookie('period-list')==null) {
            $('a.button[data-period=ever]').addClass('selected-title');
        }

        $('#sources-list li').click(function() {
            var method = $('.tabNavigation').find('.selected2').data('method');
            var source = $(this).find('a').data('source');
            var period = $('#periods-list .selected-title').data('period');
            console.log(method + ' ' + period + ' ' + source);
            //$.post('')
        });

        $('#periods-list li').click(function() {
            var method = $('.tabNavigation').find('.selected2').data('method');
            var source = $('#sources-list .selected-title').data('source');
            var period = $(this).find('a').data('period');
            console.log(method + ' ' + period + ' ' + source);
            //$.post('')
        });


        $('.categories').filter(function() {
            if($(this).children("li").length > 1) {
                $(this).each(function(){
                    $('li:eq(0)', this).addClass('first-category');
                    $('li:gt(0)', this).wrapAll('<ul class="submenu" />');
                });
                $('.submenu').hide();
                $(this).hover(function(){
                    $(this).find('.submenu').toggle();
                });
            }
        });

    });
</script>