<?php
    $this->lang->load('common');
    if($view == 'videoPage') 
    {
        $header['title']       = $data['title'].' - Videouri.com ';
        $header['description'] = $data['description'];
        $header['keywords']    = implode(', ',$data['tags']);
        $header['canonical']   = $data['canonical'];
        $this->load->view('includes/header', $header);
    }
    elseif (($view == "searchsPage") || ($view == 'tagsPage'))
    {
        $header['title'] = $searchQuery.' - Videouri.com ';
        $this->load->view('includes/header', $header);
    }
    else
    {
        $this->load->view('includes/header');
    }
?>
    <div role="main">
        <?php
            if ( ! empty($data))
            {
                $this->load->view($view, $data);
                if(($view == 'searchsPage') OR ($view == 'tagsPage')):
                ?>
                <script>
                    $(document).ready(function(){                        
                        var list              =   $("ul#videosList");

                        var dailymotion_orig = list.children('.dailymotion');
                        var metacafe_orig    = list.children('.metacafe');
                        var vimeo_orig       = list.children('.vimeo');
                        var youtube_orig     = list.children('.youtube');
                            
                        <?php if (count($data) > 1 ): ?>
                            var desc    =   false;
                            jQuery.fn.order_list = function(){
                                list.append(list.children().get().sort(function(a, b) {
                                    var aProp = $(a).find("h2").text(),
                                        bProp = $(b).find("h2").text();
                                    return (aProp > bProp ? 1 : aProp < bProp ? -1 : 0) * (desc ? -1 : 1);
                                }));
                            }
                            $().order_list();
                        <?php endif; ?>
                    });
                </script>
                <?php endif;
            }
            else
            {
                $this->load->view($view);
            }
        ?>
    </div>

    <ul id="sticky-sidebar" class="sticklr">
        <li>
            <a href="#" class="icon-search"></a>
            <ul>
                <li>
                    <?php echo form_open('results', 'method="get"'); ?>
                        <input type="text" name="search_query" value="" placeholder="Type then press Enter.." />
                    <?php echo form_close(); ?>
                </li>
            </ul>
        </li>
        
        <?php if($view=="home"): ?>
        <li>
            <a class="icon-tag" title="Go to" href="#"></a>
            <ul id="shorcuts">
                <li class="sticklr-title">
                    <a href="#">Go to</a>
                </li>
                <li>
                    <a data-target="newest" class="icon-communication"><?=lang('home_newest');?></a>
                </li>
                <li>
                    <a data-target="topRated" class="icon-communication"><?=lang('home_topRated');?></a>
                </li>
                <li>
                    <a data-target="mostViewed" class="icon-communication"><?=lang('home_mostViewed');?></a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <?php if($view=="searchsPage"): ?>
        <li>
            <a class="icon-tag" title="Site switcher" href="#"></a>
            <ul id="shorcuts">
                <li class="sticklr-title">
                    <a href="#">Go to</a>
                </li>
                <li>
                    <a class="top icon-communication">Go to top</a>
                </li>
                <li>
                    <a class="bottom icon-communication">Go to bottom</a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <li>
            <a class="icon-language" title="Change Language" href="#"></a>
            <ul id="language">
                <li class="sticklr-title">
                    <a href="#" class="icon-<?=$this->lang->lang();?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Change Language</a>
                </li>
                <li>
                    <?=anchor($this->lang->switch_uri('en'),'English',array('class'=>'icon-en'));?>
                </li>
                <li>
                    <?=anchor($this->lang->switch_uri('es'),'Español',array('class'=>'icon-es'));?>
                </li>
                <li>
                    <?=anchor($this->lang->switch_uri('ro'),'Română',array('class'=>'icon-ro'));?>
                </li>
            </ul>
        </li>

        <li>
            <a href="#" class="icon-addthis"></a>
            <ul id="social">
                <li class="sticklr-title">
                    <a href="#">Find us on</a>
                </li>
                <li>
                    <a href="https://www.facebook.com/pages/Videouri/202195183209319" class="icon-facebook" target="_blank">Facebook</a>
                </li>
                <li>
                    <a href="https://twitter.com/videouri" class="icon-twitter" target="_blank">Twitter</a>
                </li>
                <li>
                    <a href="http://www.tuenti.com/#m=Page&func=index&page_key=1_2295_65031292" class="icon-tuenti" target="_blank">Tuenti</a>
                </li>
            </ul>
        </li>
    </ul>

<?php $this->load->view('includes/footer'); ?>