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

        <link href='https://fonts.googleapis.com/css?family=Fredoka+One|Cabin&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="<?= base_url() ?>dist/videouri.css">
        <?= $this->template->stylesheet ?>

        <?php if(isset($canonical)) : ?>
        <link rel="canonical" href="<?= base_url().$canonical ?>" />
        <?php endif ?>

        <script src="<?= base_url() ?>dist/vendor/modernizr.min.js"></script>

        <script type="text/javascript">
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-CODE-HERE', 'auto');
            ga('require', 'displayfeatures');
            ga('send', 'pageview');
        </script>
    </head>

    <body id="<?= $this->template->bodyId ?>">
        <header class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-1 col-md-1 col-xs-4">
                        <a class="navbar-brand" href="<?= base_url(); ?>"> Videouri </a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-md-offset-2 col-xs-7">
                        <?= form_open('results', 'class="navbar-form" role="search" method="get" autocomplete="off"') ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="search_query" placeholder="Search"
                                            value="<?= isset($searchQuery) ? $searchQuery : '' ?>">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        <?= form_close() ?>
                    </div>
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
                    <div class="col-md-10 col-sm-10">
                        <ul class="bottom-menu-list">
                            <li><a href="/legal/termsofuse">Terms of Use</a></li>
                            <li><a href="/legal/dmca">DMCA</a></li>
                            <li>
                                <a href="//www.iubenda.com/privacy-policy/863528" class="iubenda-nostyle no-brand iubenda-embed" title="Privacy Policy">Privacy Policy</a>
                            </li>
                            <li class="hidden">
                                <a href="" class="family-filter">
                                    <?= ($this->input->cookie('ff') == "off" ? lang('ff_off') : lang('ff_on')) ?>
                                </a>
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

        <script type="text/javascript">
            (function (w,d) {var loader = function () {var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src = "//cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener("load", loader, false);}else if(w.attachEvent){w.attachEvent("onload", loader);}else{w.onload = loader;}})(window, document);
        </script>

        <script src="<?= base_url() ?>dist/videouri.js"></script>

        <?= $this->template->javascript ?>
        <?= isset($scriptCode) ? $scriptCode : '' ?>
    </body>
</html>