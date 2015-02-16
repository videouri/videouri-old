<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<!DOCTYPE html>
<html lang="en" class="no-js" xmlns:fb="http://ogp.me/ns/fb#">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <title>Santa came into town, with a "This page doesn't exist!" gift.</title>
        <meta name="description" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <meta name="copyright" content="&copy; 2012-<?= date('Y'); ?> videouri.com. All Rights Reserved." />
        <link type="text/plain" rel="author" href="<?= base_url() ?>humans.txt" />

        <meta name="robots" content="all" />

        <meta name="msvalidate.01" content="48B0A933360DDEC6CF1775D7C7E28FD3" />

        <link href='https://fonts.googleapis.com/css?family=Fredoka+One|Cabin&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="<?= base_url() ?>dist/videouri.css">
        <style type="text/css">
            h1#error-title,
            h2#error-subtitle {
                color: #31363a;
                text-align: center;
            }

            h1#error-title {
                font-size: 46px;
            }

            h2#error-subtitle {
                font-size: 22px;
            }

            #errorVid {
                margin: 0 auto;
            }
        </style>
        
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

    <body id="error">
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

        <div class="container" id="content">
            <br/>

            <div class="well">
                <h1 id="error-title">Meh... This is not the page you're looking for!</h1>
                <h2 id="error-subtitle">But, do not despair! You can either go back to the <a href="<?= base_url() ?>">homepage</a>, or watch this screaming goat remix of PSY - Gentleman</h2>

                <br/>

                <video id="errorVid" src="" class="video-js vjs-default-skin vjs-big-play-centered" autoplay preload="auto" width="640" height="360" data-setup='{ "techOrder": ["youtube"], "src": "https://www.youtube.com/watch?v=TGDFYq0THP8" }'>
                </video>
            </div>
        </div>

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
    </body>
</html>