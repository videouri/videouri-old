<section>
    <?php if(!isset($fail)) : ?>    
    <div id="results">
        <div class="resultsFor">
            <span class="searchQuery"><?=$searchQuery;?></span> tag results in 
            <span class="searchIn">
                <?php foreach($data as $key=>$value): ?>
                <strong><?=$key;?></strong>
                <?php endforeach; ?>
            </span>.
        </div>
        <ul id="videosList" class="panel">
            <?php foreach($data as $key=>$value): foreach($value as $api): ?>
            <li class="<?=$key;?>">
                <a href="<?=$api['url'];?>">
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
        There was a problem retrieving results for <span class="searchQuery"><?=$searchQuery;?></span> from 
        <span class="searchIn">
            <?php foreach($fail as $api): ?>
            <h2><?=$api;?></h2>
            <?php endforeach; ?>
        </span>. The service might be down and there for no results can be returned.
    <?php endif; ?>
</section>