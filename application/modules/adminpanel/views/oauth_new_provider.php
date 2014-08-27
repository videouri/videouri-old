<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

    <h1 class="page-title"><?php print $this->lang->line('add_oauth_provider'); ?></h1>

    <?php $this->load->view('generic/flash_error'); ?>

<?php print form_open('adminpanel/oauth_new_provider/save', array('id' => 'oauth_new_provider_form')) ."\r\n"; ?>
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
				<label for="name"><?php print $this->lang->line('provider_name'); ?></label>
				<input type="text" name="name" id="name" class="form-control" value="<?php print $this->session->flashdata('name'); ?>">
			</div>
		</div>
	</div>

    <div class="form-group">
        <label for="key"><?php print $this->lang->line('consumer_key'); ?></label>
        <input type="text" name="key" id="key" class="form-control" value="<?php print $this->session->flashdata('key'); ?>">
    </div>

    <div class="form-group">
        <label for="secret"><?php print $this->lang->line('consumer_secret'); ?></label>
        <input type="text" name="secret" id="secret" class="form-control" value="<?php print $this->session->flashdata('secret'); ?>">
    </div>

	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
				<label for="enabled"><?php print $this->lang->line('provider_enabled'); ?>?</label>
				<select name="enabled" id="enabled" class="form-control">
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>
			</div>
		</div>
	</div>
	
    <div class="form-group">
        <input type="submit" value="<?php print $this->lang->line('add_provider'); ?>" class="btn btn-primary message_cleanup">
    </div>


<?php print form_close() ."\r\n";