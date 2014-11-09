<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1 class="text-center page-title">
<?php print $this->lang->line('activate_membership_title'); ?>
</h1>

<div id="error" class="the_error">
    <?php
    if (isset($error)) {
        ?>
        <div class="alert alert-danger">
            <h4><?php print $this->lang->line('message_error_heading'); ?></h4>
            <p><?php print $error; ?></p>
        </div>
    <?php
    }
    ?>
</div>
<div id="success" class="the_error">
    <?php
    if (isset($success)) {
        ?>
        <div class="alert alert-success">
            <h4><?php print $this->lang->line('message_success_heading'); ?></h4>
            <p><?php print $success; ?></p>
        </div>
    <?php
    }
    ?>
</div>
