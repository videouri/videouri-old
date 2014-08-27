<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="oauth_container" class="col-lg-8 center-box clearfix">

	<p class="text-center">
		Click one of the icons to log in with that website.
		<br>
		Whether your are a new user or returning, social login saves you from having to create an account manually.
	</p>

	<ul class="list-inline text-center" style="margin-top: 30px;">
		<li><a href="<?php print base_url(); ?>membership/auth/oauth2/facebook" class="cim_facebook"></a></li>
		<li><a href="<?php print base_url(); ?>membership/auth/oauth/twitter" class="cim_twitter"></a></li>
		<li><a href="<?php print base_url(); ?>membership/auth/oauth2/google" class="cim_google"></a></li>
		<li><a href="<?php print base_url(); ?>membership/auth/oauth/linkedin" class="cim_linkedin"></a></li>
		<li><a href="<?php print base_url(); ?>membership/auth/oauth2/github" class="cim_github"></a></li>
		<li><a href="<?php print base_url(); ?>membership/auth/oauth2/flickr" class="cim_flickr"></a></li>
		<li><a href="<?php print base_url(); ?>membership/auth/oauth/tumblr" class="cim_tumblr"></a></li>
		<li><a href="<?php print base_url(); ?>membership/auth/oauth2/windowslive" class="cim_windowslive"></a></li>
		<li><a href="<?php print base_url(); ?>membership/auth/oauth/instagram" class="cim_instagram"></a></li>
		<li><a href="<?php print base_url(); ?>membership/auth/oauth2/paypal" class="cim_paypal"></a></li>
		<li><a href="<?php print base_url(); ?>membership/auth/oauth/soundcloud" class="cim_soundcloud"></a></li>
	</ul>

	<div class="text-center">
		<a id="regular_login" class="btn btn-default" href="javascript:">
			<?php
			print $this->uri->segment('2') == "register" ? $this->lang->line('go_to_regular_registration') : $this->lang->line('regular_login');
			?>
		</a>
	</div>
</div>