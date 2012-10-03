<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?=$this->lang->lang();?>"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="<?=$this->lang->lang();?>"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="<?=$this->lang->lang();?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?=$this->lang->lang();?>"> <!--<![endif]-->
<html lang="<?=$this->lang->lang();?>" xmlns:fb="http://ogp.me/ns/fb#">

	<head>
		<meta content="text/html; charset=UTF-8" http-equiv="content-type">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width" />

		<title><?=$this->template->title->default(lang('page_title'));?></title>
		<meta name="description" content="<?=$this->template->description->default(lang('page_description'));?>" />
		
		<meta property="og:title" content="<?=$this->template->title;?>">
		<meta property="og:site_name" content="Videouri"/>
		<meta property="og:url" content="<?=current_url();?>"/>
		<meta property="og:description" content="<?=$this->template->description;?>" />

		<?php if(isset($data['img'])): ?>
		<meta property="og:type" content="video"/>
		<meta property="og:image" content="<?=$data['img'];?>">
		<?php endif; ?>		

		<?=$this->template->meta;?>

		<meta property="fb:admins" content="1315989914"/>
		<meta property="fb:app_id" content="277719198954055"/>

		<meta http-equiv="content-language" content="<?=$this->lang->lang();?>" />
		<meta http-equiv="imagetoolbar" content="no" />
		<meta name="copyright" content="&copy; 2012 videouri.com. All Rights Reserved." />
		<meta name="robots" content="all" />

		<meta name="google-site-verification" content="-zDN10YXmnKG2hYhqYqo5xrNLMNnz1PqO6r1vSo6F38" />
		<meta name="msvalidate.01" content="48B0A933360DDEC6CF1775D7C7E28FD3" />

		<link href='http://fonts.googleapis.com/css?family=Lobster|Ubuntu:300|Cabin|Raleway&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?=base_url();?>assets/css/reset.css">
		<link rel="stylesheet/less" href="<?=base_url();?>assets/css/style.less">
		<link rel="stylesheet" href="<?=base_url();?>assets/css/jquery-sticklr-1.4-light-color.css">
		<link rel="stylesheet" href="<?=base_url();?>assets/css/jquery-ui-1.8.17.custom.css">
		<?=$this->template->stylesheet;?>
		<!--[if gte IE 9]><style type="text/css">.gradient{filter:none;}</style><![endif]-->

		<meta name="author" content="videouri.com" >
		<meta name="owner" content="videouri.com" >
		<link type="text/plain" rel="author" href="http://www.videouri.com/humans.txt" />
		<?php if(isset($canonical)) : ?>
		<link rel="canonical" href="<?=base_url().$canonical;?>" />
		<?php endif; ?>

		<script src="<?=base_url();?>assets/js/libs/modernizr-2.0.6.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?=base_url();?>assets/js/libs/jquery.min.js"><\/script>')</script>
		<script src="<?=base_url();?>assets/js/libs/jquery-ui-1.8.17.custom.min.js"></script>
		<script src="<?=base_url();?>assets/js/libs/less-1.3.0.min.js"></script>

	</head>

	<body>

		<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
		chromium.org/developers/how-tos/chrome-frame-getting-started -->
		<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

		<header>

			<div id="header_content">

				<div id="top_menu" class="gradient">
					<ul>
						<li class="left"><a href="<?=base_url();?>">Home</a></li>
						<li class="right"><a href="<?=site_url('login')?>">Login</a></li>
					</ul>
				</div>

				<div class="clearfix"></div>

				<div class="top_header">
					<a href="<?=site_url();?>"><img src="<?=base_url();?>assets/imgs/logo.png" alt="Videouri"></a>
					<?=form_open('results', 'id="search_form" class="form_wrapp" method="get" autocomplete="off"'); ?>
						<input class="inputbox" type="text" name="search_query" />
						<button class="button" type="submit"><span class="button-content"></span></button>
					<?=form_close(); ?>
				</div>

			</div>

			<div class="clearfix"></div>
			<hr/>

		</header>

		<div id="main" role="main">
			<?=$this->template->content;?>
    	</div>
    	
		<div class="clearfix"></div>

        <footer>
            <hr>
            <ul id="footer_content">
                <li class="left">&copy; 2012 videouri.com</li>
                <li class="right">
                    <ul>
                        <li>
                            <a href="" class="family-filter">
                                <?=($this->input->cookie('ff') == "off" ? lang('ff_off') : lang('ff_on')); ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </footer>

        <script>
            var uvOptions = {};
            (function() {
                var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
                uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'appwidget.uservoice.com/tkqfx5ehyGPj3L2I5YA.js?_nc=true';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
            })();
        </script>

        <?=$this->template->javascript; ?>
        <script src="<?=base_url();?>assets/js/libs/jquery.cookie.js"></script>
        <script> $.query = { spaces: false }; </script>
        <script src="<?=base_url();?>assets/js/libs/jquery.query.js"></script>
        <script src="<?=base_url();?>assets/js/libs/jquery-sticklr-1.4.min.js"></script>
        <script src="<?=base_url();?>assets/js/script.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-28752800-1'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>

        <script>
          /*var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-28752800-1']);
          _gaq.push(['_trackPageview']);
          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();*/
        </script>

    </body>
</html>