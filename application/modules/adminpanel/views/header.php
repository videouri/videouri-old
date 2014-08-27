<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		
			<?php if ($this->session->userdata('logged_in') == true) { ?>
				
				<div class="navbar-right">
					<ul class="list-unstyled list-inline">
						<li><a href="<?php print base_url(); ?>adminpanel/list_members"><i class="glyphicon glyphicon-user"></i> <?php print Adminpanel_model::$userCount; ?></a></li>
						<li>new this month: <span class="user_count"><?php print Adminpanel_model::$userCountThisMonth->count; ?></span></li>
						<li><a href="<?php print base_url(); ?>membership/logout" class="logout"><i class="glyphicon glyphicon-log-out"></i></a></li>
					</ul>
				</div>
			<?php } ?>
			
			<ul class="nav navbar-nav">
				<li<?php print ($this->uri->segment('2') == "site_settings" ? ' class="active"' : ''); ?>><a href="<?php print base_url(); ?>adminpanel/site_settings">Site settings</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Members <i class="glyphicon glyphicon-chevron-down" style="position: relative; top: 3px;"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li<?php print ($this->uri->segment('2') == "list_members" ? ' class="active"' : ''); ?>>
							<a href="<?php print base_url(); ?>adminpanel/list_members">List members</a>
						</li>
						<li<?php print ($this->uri->segment('2') == "add_member" ? ' class="active"' : ''); ?>>
							<a href="<?php print base_url(); ?>adminpanel/add_member">Add member</a>
						</li>
					</ul>
				</li>
				<li<?php print ($this->uri->segment('2') == "oauth_providers" ? ' class="active"' : ''); ?>>
					<a href="<?php print base_url(); ?>adminpanel/oauth_providers">Social providers</a>
				</li>
				<li<?php print ($this->uri->segment('2') == "backup_export" ? ' class="active"' : ''); ?>>
					<a href="<?php print base_url(); ?>adminpanel/backup_export">Backup &amp; export</a>
				</li>
			</ul>
				
	</div><!-- /.navbar-collapse -->
</nav>