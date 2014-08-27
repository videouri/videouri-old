<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1 class="text-center page-title">
	<?php print $this->lang->line('login'); ?>
</h1>

<div class="container">
	<div class="row">
		
		<div class="col-lg-4 col-sm-6 col-xs-8 center-box clearfix">
			<?php
			if (Settings_model::$db_config['login_enabled'] == 0)
			{
				?>
				<div id="error" class="alert alert-danger">
					<p><?php print $this->lang->line('login_disabled') ?></p>
				</div>
			<?php
			}else{
				$this->load->view('generic/flash_error');
			}
			?>
		</div>
		
		<?php $this->load->view('themes/bootstrap3/membership/oauth'); ?>
		
		<div class="col-lg-4 col-sm-6 col-xs-8 clearfix center-box">

			<div id="regular_wrapper">
				<?php print form_open('membership/login/validate', 'id="login_form" class="regular_form"') ."\r\n"; ?>
			
				<div class="form-group">
					<div id="oauth_login_wrapper">
						<p class="text-center"><a id="oauth_login" class="btn btn-default" href="javascript:"><?php print $this->lang->line('social_login'); ?></a>
					</div>
				</div>
				
				<div class="form-group">
					<label for="login_username"><?php //print $this->lang->line('username'); ?></label>
					<input type="text" name="username" id="login_username" class="form-control tooltip_target" placeholder="<?php print $this->lang->line('username'); ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('username_requirements'); ?>">
				</div>
				
				<div class="form-group">
					<label for="login_password"><?php //print $this->lang->line('password'); ?></label>
					<input type="password" name="password" id="login_password" class="form-control tooltip_target" placeholder="<?php print $this->lang->line('password'); ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('password_requirements'); ?>">
				</div>
				<div class="form-group">
					<?php if (Settings_model::$db_config['remember_me_enabled'] == true) { ?>
					<p>
						<label for="remember_me"><?php print $this->lang->line('remember_me'); ?></label>
						<?php print form_checkbox(array('name' => 'remember_me', 'id' =>'remember_me', 'value' => 'accept', 'checked' => FALSE)); ?>
					</p>
					<?php } ?>
				</div>
				
				<div class="recaptcha-wrapper">
				<?php
				if ($this->session->userdata('login_attempts') > 5) {
					if (Settings_model::$db_config['recaptcha_enabled'] == true) {
						print $this->recaptcha->get_html();
					}
				}
				?>
				</div>
				
				<div class="form-group">
					<input type="submit" name="submit" id="login_submit" value="<?php print $this->lang->line('login'); ?>" class="btn btn-primary btn-loading">
					<span class="loading"><img src="<?php print base_url(); ?>images/loaderB16.gif" alt=""></span>
				</div>

				<?php print form_close() ."\r\n"; ?>
			</div>
			
		</div>
	</div>
</div>