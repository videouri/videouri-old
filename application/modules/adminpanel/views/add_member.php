<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1 class="page-title"><?php print $this->lang->line('add_member'); ?></h1>

<?php $this->load->view('generic/flash_error'); ?>

<?php print form_open('adminpanel/add_member/add', array('id' => 'add_member_form')) ."\r\n"; ?>

<div class="row">
	<div class="col-xs-6">
		<div class="form-group">
			<label for="first_name"><?php print $this->lang->line('first_name'); ?></label>
			<input type="text" name="first_name" id="first_name" class="form-control" value="<?php print $this->session->flashdata('first_name'); ?>">
		</div>

		<div class="form-group">
			<label for="last_name"><?php print $this->lang->line('last_name'); ?></label>
			<input type="text" name="last_name" id="last_name" class="form-control" value="<?php print $this->session->flashdata('last_name'); ?>">
		</div>

		<div class="form-group">
			<label for="email"><?php print $this->lang->line('email_address'); ?></label>
			<input type="text" name="email" id="email" class="form-control" value="<?php print $this->session->flashdata('email'); ?>">
		</div>

		<div id="email_valid"></div>
		<div id="email_taken"></div>

		<div class="form-group">
			<label for="reg_username"><?php print $this->lang->line('username'); ?></label>
			<input type="text" name="username" id="reg_username" class="form-control" value="<?php print $this->session->flashdata('username'); ?>">
		</div>

		<div id="username_valid"></div>
		<div id="username_taken"></div>
		<div id="username_length"></div>
	</div>

	<div class="col-xs-6">
		<div class="form-group">
			<label for="reg_password"><?php print $this->lang->line('password'); ?></label>
			<input type="password" name="password" id="reg_password" class="form-control">
		</div>

		<div class="form-group">
			<label for="password_confirm"><?php print $this->lang->line('confirm_password'); ?></label>
			<input type="password" name="password_confirm" id="password_confirm" class="form-control">
		</div>

		<p class="spacer">
			<input type="submit" name="membership_submit" id="membership_submit" value="<?php print $this->lang->line('add_member'); ?>" class="btn btn-primary">
		</p>

		<?php print form_close() ."\r\n"; ?>
	</div>
</div>