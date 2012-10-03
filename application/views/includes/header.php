<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?=$this->lang->lang();?>"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="<?=$this->lang->lang();?>"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="<?=$this->lang->lang();?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?=$this->lang->lang();?>"> <!--<![endif]-->
<html lang="<?=$this->lang->lang();?>" xmlns:fb="http://ogp.me/ns/fb#">
	<head>
		<meta charset="utf-8">

		<?php if(isset( $title )): ?>
		<meta property="og:title" content="<?=$title;?>">
		<title><?=$title;?></title>
		<?php else: ?>
		<meta property="og:title" content="<?=lang('page_title');?>">
		<title><?=lang('page_title');?></title>
		<?php endif; ?>
		
		<meta property="og:site_name" content="Videouri"/>
		<meta property="og:url" content="<?=current_url();?>"/>
		<?php if(isset($data['img'])): ?>
		<meta property="og:type" content="video"/>
		<meta property="og:image" content="<?=$data['img'];?>">
		<?php endif; ?>

		<?php if(isset( $description )): ?>
		<meta name="description" content="<?=$description;?>" />
		<meta property="og:description" content="<?=$description;?>" />
		<?php else: ?>
		<meta name="description" content="<?=lang('page_description')?>" />
		<meta property="og:description" content="<?=lang('page_description')?>" />
		<?php endif; ?>

		<?php if(isset( $keywords )): ?>
		<meta name="keywords" content="<?=$keywords;?>" />
		<?php else: ?>
		<meta name="keywords" content="<?=lang('page_keywords')?>" />
		<?php endif; ?>
		
		<meta property="fb:admins" content="1315989914"/>
		<meta property="fb:app_id" content="277719198954055"/>

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width" />

		<meta http-equiv="content-language" content="<?=$this->lang->lang();?>" />
		<meta name="copyright" content="&copy; 2012 videouri.com. All Rights Reserved." />
		<meta name="robots" content="all" />
		<meta http-equiv="imagetoolbar" content="no" />

		<meta name="google-site-verification" content="-zDN10YXmnKG2hYhqYqo5xrNLMNnz1PqO6r1vSo6F38" />
		<meta name="msvalidate.01" content="48B0A933360DDEC6CF1775D7C7E28FD3" />
		
		<link href='http://fonts.googleapis.com/css?family=Lobster|Ubuntu:300|Cabin|Raleway&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?=base_url();?>assets/css/reset.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?=base_url();?>assets/css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?=base_url();?>assets/css/jquery-sticklr-1.4-light-color.css" type="text/css" />
		<link rel="stylesheet" href="<?=base_url();?>assets/css/jquery-ui-1.8.17.custom.css" type="text/css" />
		<!--[if gte IE 9]><style type="text/css">.gradient{filter:none;}</style><![endif]-->
		<link type="text/plain" rel="author" href="http://www.videouri.com/humans.txt" />
		<?php if(isset($canonical)) : ?>
		<link rel="canonical" href="<?=$canonical;?>" />
		<?php endif; ?>

		<script src="<?=base_url();?>assets/js/libs/modernizr-2.0.6.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?=base_url();?>assets/js/libs/jquery.min.js"><\/script>')</script>
		<script src="<?=base_url();?>assets/js/libs/jquery-ui-1.8.17.custom.min.js"></script>
	</head>
	<body>
		<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
		chromium.org/developers/how-tos/chrome-frame-getting-started -->
		<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
		<header>
			<div id="headerContainer">

				<div class="top_menu gradient">
					<ul>
						<li class="left">
							<a href="<?=base_url();?>">Home</a>
						</li>
						<li class="welcome">Welcome <span class="variable">Guest</span></li>
						<li class="right"><a href="<?=site_url('login')?>">Login</a></li>
					</ul>
				</div>
				<div class="clearfix"></div>

				<div class="top_header">
					<h1><a href="<?=site_url();?>">&nbsp;videouri.com&nbsp;</a></h1>
					<?=form_open('results', 'id="search_form" class="form_wrapp" method="get" autocomplete="off"'); ?>
						<input class="inputbox" type="text" name="search_query" />
						<button class="button" type="submit"><span class="button-content"></span></button>
					<?=form_close(); ?>
				</div>

			</div>
			<div class="clearfix"></div>
			<hr/>
		</header>