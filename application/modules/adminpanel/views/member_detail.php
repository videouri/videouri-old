<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

    <h1 class="page-title">Member detail</h1>

    <?php $this->load->view('generic/flash_error'); ?>

    <h2>
        <?php print $this->lang->line('viewing_member'); ?>: <strong><?php print $member->username; ?></strong>
    </h2>

    <p>
        <span class="form_subtext"><?php print $this->lang->line('last_login'); ?>:</span>
        <?php print $member->last_login; ?>
    </p>

    <p>
        <span class="form_subtext"><?php print $this->lang->line('date_registered'); ?>:</span>
        <?php print $member->date_registered; ?>
    </p>

	<div class="row">
		<div class="col-xs-6">
			<?php print form_open('adminpanel/member_detail/save') ."\r\n"; ?>

			<div class="form-group">
				<label for="username"><?php print $this->lang->line('username'); ?></label>
				<input type="text" name="username" id="username" value="<?php print $member->username; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('username_requirements'); ?>" class="form-control tooltip_target">
			</div>

			<div class="form-group">
				<label for="email"><?php print $this->lang->line('email_address'); ?></label>
				<input type="text" name="email" id="email" value="<?php print $member->email; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('email_requirements'); ?>" class="form-control tooltip_target">
			</div>

			<div class="form-group">
				<label for="first_name"><?php print $this->lang->line('first_name'); ?></label>
				<input type="text" name="first_name" id="first_name" value="<?php print $member->first_name; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('first_name_requirements'); ?>" class="form-control tooltip_target">
			</div>

			<div class="form-group">
				<label for="last_name"><?php print $this->lang->line('last_name'); ?></label>
				<input type="text" name="last_name" id="last_name" value="<?php print $member->last_name; ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('last_name_requirements'); ?>" class="form-control tooltip_target">
			</div>
		</div>

		<div class="col-xs-6">
			<div class="form-group">
				<label for="role"><?php print $this->lang->line('role'); ?></label>
				<?php if (!empty($roles)) { ?>
					<select name="role" id="role" class="form-control">
						<?php foreach ($roles as $role) { ?>
							<option value="<?php print $role->id; ?>"<?php print ($role->id == $member->role_id ? ' selected="selected"' : ''); ?>><?php print $role->name; ?></option>
						<?php } ?>
					</select>
				<?php } ?>
			</div>

			<div class="form-group">
				<label for="banned"><?php print $this->lang->line('banned'); ?>?</label>
				<select name="banned" id="banned" class="form-control">
					<option value="0"<?php print ($member->banned == false ? ' selected="selected"' : ''); ?>>No</option>
					<option value="1"<?php print ($member->banned == true ? ' selected="selected"' : ''); ?>>Yes</option>
				</select>
			</div>

			<div class="form-group">
				<label for="active"><?php print $this->lang->line('activated'); ?>?</label>
				<select name="active" id="active" class="form-control">
					<option value="1"<?php print ($member->active == true ? ' selected="selected"' : ''); ?>>Yes</option>
					<option value="0"<?php print ($member->active == false ? ' selected="selected"' : ''); ?>>No</option>
				</select>
			</div>

			<div class="form-group">
				<label for="new_password"><?php print $this->lang->line('new_password'); ?></label>
				<input type="password" name="new_password" id="new_password" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('password_requirements'); ?>" class="form-control tooltip_target">
			</div>

			<div class="form-group">
				<label for="send_copy" class="inline"><?php print $this->lang->line('send_copy'); ?></label>
				<input type="checkbox" name="send_copy" id="send_copy" value="accept" checked="checked" class="form_control label_checkbox">
			</div>

			<div class="form-group">
				<input type="submit" value="<?php print $this->lang->line('save_member_data'); ?>" class="btn btn-primary">
				<input type="hidden" name="id" value="<?php print $member->id; ?>">
			</div>

			<?php print form_close() ."\r\n"; ?>
		</div>
	</div>