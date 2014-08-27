<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

    <?php print form_open('adminpanel/backup_export/export_members', array('id' => 'export_members_form')) ."\r\n"; ?>

    <h1 class="page-title"><?php print $this->lang->line('backup_and_export'); ?></h1>

    <?php $this->load->view('generic/flash_error'); ?>

    <h2><?php print $this->lang->line('export_title'); ?></h2>

    <p>
        <span class="form_subtext">This e-mail will be sent to the admin e-mail entered in site settings.</span>
    </p>

    <p class="spacer">
        <input type="submit" name="export_submit" id="export_submit" value="Export memberlist" class="message_cleanup btn btn-primary">
    </p>

    <?php print form_close() ."\r\n";

    print form_open('adminpanel/backup_export/export_database', array('id' => 'export_database_form')) ."\r\n"; ?>

    <h2><?php print $this->lang->line('backup_title'); ?></h2>

    <p>
        <span class="form_subtext">This e-mail will be sent to the admin e-mail entered in site settings.</span>
        <span class="form_subtext">WARNING 1: for very large databases this might not be possible and you will have to export directly from the MySQL command line.</span>
        <span class="form_subtext">WARNING 2: you might want to take your MySQL server offline before backing up. Disable site login before doing this.</span>
    </p>

    <p class="spacer">
        <input type="submit" name="db_backup_submit" id="db_backup_submit" value="Export database" class="message_cleanup btn btn-primary">
    </p>

    <?php print form_close() ."\r\n";