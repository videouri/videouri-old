<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1 class="page-title"><?php print $this->lang->line('my_profile'); ?></h1>

<div>
	<?php $this->load->view('generic/flash_error'); ?>
</div>

<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6">
	
		<p class="lead"><?php print $this->lang->line('you_are_logged_in_with'); ?> <strong><?php print $provider_name; ?></strong></p>
	
		<?php print form_open('private/oauth_profile/update_profile', array('id' => 'oauth_profile_form')) ."\r\n"; ?>
		
		<div class="form-group">
			<label for="first_name"><?php print $this->lang->line('first_name'); ?></label>
			<input type="text" name="first_name" id="first_name" class="form-control tooltip_target" value="<?php print $first_name; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('first_name_requirements'); ?>">
		</div>
		
		<div class="form-group">
			<label for="last_name"><?php print $this->lang->line('last_name'); ?></label>
			<input type="text" name="last_name" id="last_name" class="form-control tooltip_target" value="<?php print $last_name; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('last_name_requirements'); ?>">
		</div>
		
		<div class="form-group">
			<label for="email"><?php print $this->lang->line('change_email'); ?></label>
			<input type="text" name="email" id="email" class="form-control tooltip_target" value="<?php print $email; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('email_requirements'); ?>">
		</div>
		
		<div class="form-group">
			<input type="submit" value="<?php print $this->lang->line('save_profile'); ?>" id="oauth_profile_submit" class="message_cleanup btn btn-primary btn-loading">
			<span class="loading"><img src="<?php print base_url(); ?>images/loaderB16.gif" alt=""></span>
			<input type="hidden" name="id" value="<?php print $id; ?>" />
		</div>
		
		<?php print form_close() ."\r\n"; ?>
		
		<?php print form_open('private/oauth_profile/delete_account', array('id' => 'delete_profile_form')) ."\r\n"; ?>
		
		<div class="form-group">
			<label for="permanently_remove"><?php print $this->lang->line('permanently_delete_account'); ?></label>
			<br>
			<input type="submit" id="permanently_remove" class="btn btn-primary btn-loading confirm_delete" value="<?php print $this->lang->line('delete_account_now'); ?>">
			<span class="loading"><img src="<?php print base_url(); ?>images/loaderB16.gif" alt=""></span>
		</div>
		
		<?php print form_close() ."\r\n"; ?>
		
	</div>
</div>

