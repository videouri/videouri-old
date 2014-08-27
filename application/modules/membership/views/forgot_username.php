<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1 class="text-center page-title">
	<?php print $this->lang->line('forgot_username'); ?>
</h1>

<div class="container">
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-xs-8 form-container center-box">
			
			<div>
				<?php
				$this->load->view('generic/flash_error');
				?>
			</div>
			
			<?php print form_open('membership/forgot_username/send_username', array('id' => 'username_form')) ."\r\n"; ?>

			<div class="form-group">
				<label for="email"><?php //print $this->lang->line('your_email'); ?></label>
				<input type="text" name="email" id="email" class="form-control" placeholder="<?php print $this->lang->line('your_email'); ?>">
			</div>

			<div class="recaptcha-wrapper">
			<?php
			if (Settings_model::$db_config['recaptcha_enabled'] == true) {
				print $this->recaptcha->get_html();
			}
			?>
			</div>
			
			<div class="form-group">
				<input type="submit" name="forgot_username_submit" class="check_email_empty btn btn-primary" value="<?php print $this->lang->line('send_username'); ?>">
				<span class="loading"><img src="<?php print base_url(); ?>images/loaderB16.gif" alt=""></span>
			</div>
			
			<?php print form_close() ."\r\n"; ?>
		</div>
		
	</div>
</div>

