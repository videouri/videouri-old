<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<!DOCTYPE html>
<html lang="en" class="no-js" xmlns:fb="http://ogp.me/ns/fb#">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <title><?= $this->template->title->default(lang('page_title')) ?></title>
        <meta name="description" content="<?= $this->template->description->default(lang('page_description')) ?>" />

        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <meta property="og:title" content="<?= $this->template->title ?>">
        <meta property="og:site_name" content="Videouri"/>
        <meta property="og:url" content="http://<?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>"/>
        <meta property="og:description" content="<?= $this->template->description ?>" />

        <?php if(isset($img)): ?>
        <meta property="og:type" content="video"/>
        <meta property="og:image" content="<?= $img ?>">
        <?php endif ?>      

        <?= $this->template->meta ?>

        <meta property="fb:app_id" content="277719198954055"/>

        <meta name="copyright" content="&copy; 2012-<?= date('Y'); ?> videouri.com. All Rights Reserved." />
        <link type="text/plain" rel="author" href="<?= base_url() ?>humans.txt" />

        <meta name="robots" content="all" />

        <meta name="msvalidate.01" content="48B0A933360DDEC6CF1775D7C7E28FD3" />

        <link href='https://fonts.googleapis.com/css?family=Lobster|Ubuntu:300|Cabin|Raleway&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <!-- <link rel="stylesheet" href="<?= base_url() ?>stylesheets/css/jquery-sticklr-1.4-light-color.css"> -->
        <link rel="stylesheet" href="<?= base_url() ?>dist/videouri.css">
        <?= $this->template->stylesheet ?>
        <!--[if gte IE 9]><style type="text/css">.gradient{filter:none;}</style><![endif]-->
        
        <?php if(isset($canonical)) : ?>
        <link rel="canonical" href="<?= base_url().$canonical ?>" />
        <?php endif ?>

        <script src="<?= base_url() ?>dist/vendor/modernizr.min.js"></script>

        <script type="text/javascript">
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-28752800-1', 'auto');
            ga('require', 'displayfeatures');
            ga('send', 'pageview');
        </script>
    </head>

    <body id="<?= $this->template->bodyId ?>">
        <header class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-1 col-md-1 div-col-xs-2">
                        <a class="navbar-brand" href="<?= base_url(); ?>"> Videouri </a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-md-offset-2">
                        <?= form_open('results', 'class="navbar-form" role="search" method="get" autocomplete="off"') ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="search_query" placeholder="Search"
                                            value="<?= isset($searchQuery) ? $searchQuery : '' ?>">
                                    <span class="input-group-btn">
                                        <?php if (false): // @TODO ?>
                                        <!-- <button class="btn" data-toggle="dropdown">
                                            <i class="fa fa-filter"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-inverse" role="menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li><a href="#">Something else here</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                        </ul> -->
                                        <?php endif ?>
                                        <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        <?= form_close() ?>
                    </div>
                    <?php if (false): // @TODO ?>
                    <div class="col-md-3">
                        <ul class="nav navbar-nav navbar-right">
                            <?php if ($this->session->userdata('logged_in') == true): ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    Alex <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </li>
                            <?php else: ?>
                            <li>
                                <a href="<?= base_url(); ?>/signin" class="modal-trigger">
                                    <?= $this->lang->line('signin'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url(); ?>/signup" class="modal-trigger">
                                    <?= $this->lang->line('signup'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <?php if ($this->router->fetch_class() === 'home' && $this->router->fetch_method() === 'index'): ?>
            <?= $this->template->home_featured ?>
        <?php endif; ?>
        <div class="clearfix"></div>


        <?php $dontWrap = filter_var($this->template->dontWrap, FILTER_VALIDATE_BOOLEAN); ?>
        <?php if ($dontWrap === true): ?>
            <?= $this->template->content ?>
        <?php else: ?>
            <div class="container" id="content">
                <?= $this->template->content ?>
            </div>
        <?php endif; ?>

        <div class="bottom-menu bottom-menu-inverse">
            <div class="container">
                <div class="row">
                    <!-- <div class="col-md-2 col-sm-2">
                        <a href="#fakelink" class="bottom-menu-brand">Flat UI</a>
                    </div> -->
                    <div class="col-md-10 col-sm-10">
                        <ul class="bottom-menu-list">
                            <li><a href="/legal/termsofuse">Terms of Use</a></li>
                            <li><a href="/legal/dmca">DMCA</a></li>
                            <li>
                                <a href="//www.iubenda.com/privacy-policy/863528" class="iubenda-nostyle no-brand iubenda-embed" title="Privacy Policy">Privacy Policy</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-2 text-right">
                        <ul class="bottom-menu-iconic-list">
                            <li><a href="https://facebook.com/Videouri" target="_blank" class="fa fa-facebook"></a></li>
                            <li><a href="https://twitter.com/Videouri" target="_blank" class="fa fa-twitter"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <footer class="hidden">
            <hr>
            <ul id="footer_content">
                <li class="left">&copy; 2012 videouri.com</li>
                <li class="right">
                    <ul>
                        <li>
                            <a href="" class="family-filter">
                                <?= ($this->input->cookie('ff') == "off" ? lang('ff_off') : lang('ff_on')) ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </footer>

        <?php if (false): // @TODO ?>
        <!-- .modal -->
        <div id="videouri-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <p><i class="icon-spinner icon-spin icon-large"></i> Loading...</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
        <!-- / .modal -->
        <?php endif ?>


        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54d2a8836c546f73" async="async"></script>

        <script type="text/javascript">
            (function (w,d) {var loader = function () {var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src = "//cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener("load", loader, false);}else if(w.attachEvent){w.attachEvent("onload", loader);}else{w.onload = loader;}})(window, document);
        </script>

        <!-- <script data-main="/scripts/build" src="/dist/require.js"></script> -->
        <script src="<?= base_url() ?>dist/videouri.js"></script> 

        <?= $this->template->javascript ?>
        <?= isset($scriptCode) ? $scriptCode : '' ?>

        <script type="text/javascript">
            // $("select[name='video-category']").css('border', '1px solid red');
            // $("select[name='video-category']").selectpicker({style: 'btn-primary', menuStyle: 'dropdown-inverse'});
            // requirejs(["module/home"]);
        </script>
    </body>
</html>