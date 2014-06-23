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
        <meta property="og:url" content="<?= current_url() ?>"/>
        <meta property="og:description" content="<?= $this->template->description ?>" />

        <?php if(isset($data['img'])): ?>
        <meta property="og:type" content="video"/>
        <meta property="og:image" content="<?= $data['img'] ?>">
        <?php endif ?>      

        <?= $this->template->meta ?>

        <meta property="fb:admins" content="1315989914"/>
        <meta property="fb:app_id" content="277719198954055"/>

        <meta http-equiv="content-language" content="en" />
        <meta http-equiv="imagetoolbar" content="no" />
        <meta name="copyright" content="&copy; 2012 videouri.com. All Rights Reserved." />
        <meta name="robots" content="all" />

        <meta name="google-site-verification" content="-zDN10YXmnKG2hYhqYqo5xrNLMNnz1PqO6r1vSo6F38" />
        <meta name="msvalidate.01" content="48B0A933360DDEC6CF1775D7C7E28FD3" />

        <link href='http://fonts.googleapis.com/css?family=Lobster|Ubuntu:300|Cabin|Raleway&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?= base_url() ?>assets/stylesheets/css/jquery-sticklr-1.4-light-color.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/stylesheets/css/main.css">
        <?= $this->template->stylesheet ?>
        <!--[if gte IE 9]><style type="text/css">.gradient{filter:none;}</style><![endif]-->

        <meta name="author" content="videouri.com" >
        <meta name="owner" content="videouri.com" >
        <link type="text/plain" rel="author" href="<?= base_url() ?>humans.txt" />
        <?php if(isset($canonical)) : ?>
        <link rel="canonical" href="<?= base_url().$canonical ?>" />
        <?php endif ?>

        <script src="<?= base_url() ?>assets/scripts/vendor/modernizr-2.7.1.min.js"></script>
    </head>

    <body id="<?= $this->template->body_id; ?>">
        <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <header class="hidden">
            <div id="header_content">
                <div class="top_header">
                    <a href="<?= site_url() ?>"><img src="<?= base_url() ?>assets/imgs/logo.png" alt="Videouri"></a>
                    <?= form_open('results', 'id="search_form" class="form_wrapp hidden" method="get" autocomplete="off"') ?>
                        <input class="inputbox" type="text" name="search_query" />
                        <button class="button" type="submit"><span class="button-content"></span></button>
                    <?= form_close() ?>
                </div>
            </div>
        </header>

        <header class="navbar navbar-default navbar-fixed-top">
            <div class="row">
                <div class="div-lg-1 col-md-1 div-col-xs-2">
                    <a class="navbar-brand"> Videouri </a>
                </div>
                <div class="col-md-6 col-md-offset-2">
                    <form class="navbar-form" action="#" role="search">
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control" type="search" placeholder="Search">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn"><span class="fui-search"></span></button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </header>

        <?php if ($this->router->fetch_class() === 'home' && $this->router->fetch_method() === 'index'): ?>
            <?= $this->template->home_featured ?>
        <?php endif; ?>
        <div class="clearfix"></div>

        <div class="container">
            <?= $this->template->content ?>
        </div>

        <footer>
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

        <script data-main="/assets/scripts/build" src="/assets/scripts/vendor/require.js"></script>
        <!--<script data-main="/assets/scripts/videouri" src="/assets/scripts/vendor/require.js"></script> -->

        <?= $this->template->javascript ?>

        <script type="text/javascript">
            // $("select[name='video-category']").css('border', '1px solid red');
            // $("select[name='video-category']").selectpicker({style: 'btn-primary', menuStyle: 'dropdown-inverse'});
            requirejs(["main", "module/home"]);
        </script>

        <script>
        
            var _gaq=[['_setAccount','UA-28752800-1'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));

        </script>

    </body>
</html>