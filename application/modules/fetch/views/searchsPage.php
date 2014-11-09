<section>

    <?php if(!isset($fail)) : ?>
    <div id="results">

        <div class="inside_top_bar">
            <div class="resultsFor">
                Search results for <span class="query"><?= $query; ?></span> in 
                <span class="searchIn">
                    <?php foreach($data as $key => $value): ?>
                    <strong><?=$key;?></strong>
                    <?php endforeach; ?>
                </span>.
            </div>

            <div class="filters_sorts">
                <?php if((count($data) > 0) && (count($data) !== 1)) : ?>
                <h3>Filter Source</h3>
                <ul id="filter_sources">
                    <?php foreach($data as $api=>$v) : ?>
                    <li><input type="checkbox" name="source" value="<?=mb_strtolower($api);?>" checked="false"/><span style="text-transform: capitalize;"><?=$api;?></span></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>

        <ul id="videosList" class="">
            <?php foreach($data as $key=>$value): foreach($value as $api): ?>
            <li class="<?=$key;?>">
                <a href="<?=$api['url'];?>" alt="<?=$api['title'];?>">
                    <div></div>            
                    <img src="<?=$api['img'];?>" alt="<?=$api['title'];?>" height="150" width="200">
                    <h2><?=$api['title'];?></h2>
                </a>
            </li>
            <?php endforeach; endforeach; ?>
        </ul>
        <div class="clearfix"></div>
        <div id="page" class="left">
            <input type="button" class="previous" value="<< <?=lang('previous_button');?>">
            <input type="button" class="next" value="<?=lang('next_button');?> >>">
        </div>
    </div>
    <?php else: ?>
        <div class="resultsFor">
        There was a problem retrieving results for <span class="query"><?=$query;?></span> from 
        <span class="searchIn">
            <?php foreach($fail as $api): ?>
            <h2><?=$api;?></h2>
            <?php endforeach; ?>
        </span>. The service might be down and there for no results can be returned.
    <?php endif; ?>

    <div class="clearfix"></div>

</section>
