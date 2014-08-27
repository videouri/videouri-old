<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php print base_url(); ?>">CI Membership</a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		
			<?php if ($this->session->userdata('logged_in') == true) { ?>
				<ul class="nav navbar-nav">
					<?php if ($this->session->userdata('username') == ADMINISTRATOR) { ?>
					<li<?php print ($this->uri->segment('2') == "login" ? ' class="active"' : ''); ?>><a href="<?php print base_url(); ?>adminpanel/site_settings">Adminpanel</a></li>
					<?php } ?>
					<li<?php print ($this->uri->segment('2') == "login" ? ' class="active"' : ''); ?>><a href="<?php print base_url(); ?>">Home</a></li>
				</ul>
				<p class="navbar-text navbar-right">
				<i class="glyphicon glyphicon-user"></i> <?php print $this->lang->line('logged_in_as'); ?>: <a href="<?php print site_url('private/'. ($this->session->userdata('is_oauth') == true ? "oauth_" : "") .'profile'); ?>" title="edit profile" class="navbar-link"><b><?php print $this->session->userdata('username'); ?></b></a>
				<span class="log_out"><a href="<?php print base_url(); ?>membership/logout"><?php print $this->lang->line('logout'); ?></a></span>
				</p>
			<?php }else{ ?>
				<ul class="nav navbar-nav navbar-right">
					<li<?php print ($this->uri->segment('2') == "login" ? ' class="active"' : ''); ?>><a href="<?php print base_url(); ?>membership/login"><?php print $this->lang->line('login'); ?></a></li>
					<li<?php print ($this->uri->segment('2') == "register" ? ' class="active"' : ''); ?>><a href="<?php print base_url(); ?>membership/register"><?php print $this->lang->line('create_account'); ?></a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print $this->lang->line('login_help'); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php print base_url(); ?>membership/forgot_username"><?php print $this->lang->line('forgot_username'); ?></a></li>
							<li><a href="<?php print base_url(); ?>membership/forgot_password"><?php print $this->lang->line('forgot_password'); ?></a></li>
							<li><a href="<?php print base_url(); ?>membership/resend_activation"><?php print $this->lang->line('resend_activation'); ?></a></li>
						</ul>
					</li>
				</ul>
			<?php } ?>
	</div><!-- /.navbar-collapse -->
</nav>