<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1 class="page-title"><?php print $this->lang->line('my_profile'); ?></h1>

<div>
    <?php $this->load->view('generic/flash_error'); ?>
</div>

<h2>
    <?php print $this->lang->line('personal_details'); ?>
</h2>

<div class="row">
	
	<?php print form_open('private/profile/update_account', array('id' => 'profile_form')) ."\r\n"; ?>
	<div class="col-lg-6 col-md-6 col-sm-6">
		<div class="form-group">
			<label for="profile_first_name"><?php print $this->lang->line('first_name'); ?></label>
			<input type="text" name="first_name" id="profile_first_name" class="form-control tooltip_target" value="<?php print $first_name; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('first_name_requirements'); ?>">
		</div>
		
		<div class="form-group">
			<label for="profile_last_name"><?php print $this->lang->line('last_name'); ?></label>
			<input type="text" name="last_name" id="profile_last_name"  class="form-control tooltip_target" value="<?php print $last_name; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('last_name_requirements'); ?>">
		</div>
		
		<div class="form-group">
			<label for="profile_email"><?php print $this->lang->line('change_email'); ?></label>
			<input type="text" name="email" id="profile_email" class="form-control tooltip_target" value="<?php print $email; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('email_requirements'); ?>">
		</div>
	</div>
	
	<div class="col-lg-6 col-md-6 col-sm-6">
		<div class="form-group">
			<label for="profile_password"><?php print $this->lang->line('password_required_for_changes'); ?></label>
			<input type="password" name="password" id="profile_password" class="form-control">
		</div>

		<div class="form-group">
			<input type="submit" name="profile_submit" id="profile_submit" value="<?php print $this->lang->line('update_profile'); ?>" class="btn btn-primary btn-loading">
			<span class="loading"><img src="<?php print base_url(); ?>images/loaderB16.gif" alt=""></span>
			<input type="hidden" name="id" value="<?php print $id; ?>" />
		</div>
	</div>
	<?php print form_close() ."\r\n"; ?>
	
	<?php print form_open('private/profile/delete_account', array('id' => 'delete_profile_form')) ."\r\n"; ?>
	<div class="col-lg-6 col-md-6 col-sm-6">
		<div class="form-group">
			<label for="permanently_remove"><?php print $this->lang->line('permanently_delete_account'); ?></label>
			<br>
			<input type="submit" id="permanently_remove" class="btn btn-primary btn-loading confirm_delete" value="<?php print $this->lang->line('delete_account_now'); ?>">
			<span class="loading"><img src="<?php print base_url(); ?>images/loaderB16.gif" alt=""></span>
		</div>
	</div>
	<?php print form_close() ."\r\n"; ?>
	
</div>


<?php print form_open('private/profile/update_password', array('id' => 'profile_pwd_form')) ."\r\n"; ?>

<div id="pwd_error" class="the_error">
    <?php
    if ($this->session->flashdata('pwd_error')) {
        ?>
        <div class="alert alert-danger">
            <h4>Password error:</h4>
            <p><?php print $this->session->flashdata('pwd_error'); ?></p>
        </div>
    <?php
    }
    ?>
</div>
<div id="success" class="the_error">
    <?php
    if ($this->session->flashdata('pwd_success')) {
        ?>
        <div class="alert alert-success">
            <h4>Success!!</h4>
            <p><?php print $this->session->flashdata('pwd_success'); ?></p>
        </div>
    <?php
    }
    ?>
</div>

<h2>
    <?php print  $this->lang->line('edit_password'); ?>
</h2>

<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6">
	
		<div class="form-group">
			<label for="current_password"><?php print $this->lang->line('current_password'); ?></label>
			<input type="password" name="current_password" id="current_password" class="form-control">
		</div>
		
		<div class="form-group">
			<label for="profile_new_password"><?php print $this->lang->line('new_password'); ?></label>
			<input type="password" name="new_password" id="profile_new_password" class="form-control tooltip_target" data-original-title="<?php print $this->lang->line('password_requirements'); ?>">
		</div>
		
		<div class="form-group">
			<label for="new_password_again"><?php print $this->lang->line('new_password_again'); ?></label>
			<input type="password" name="new_password_again" id="new_password_again" class="form-control tooltip_target">
		</div>
		
		<div class="form-group">
			<label for="profile_new_password"><?php print $this->lang->line('send_copy_to_email'); ?></label>
			<?php print form_checkbox(array('name' => 'send_copy', 'value' => 'accept', 'checked' => TRUE, 'class' => 'checkbox')); ?>
		</div>
	</div>
</div>

<?php print form_hidden('email', $email); ?>

<input type="submit" name="submit" id="profile_pwd_submit" value="<?php print $this->lang->line('update_password'); ?>" class="btn btn-primary btn-loading">
<span class="loading"><img src="<?php print base_url(); ?>images/loaderB16.gif" alt=""></span>

<?php print form_close() ."\r\n"; ?>
