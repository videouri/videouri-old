<div id="error" class="the_error">
    <?php
    if ($this->session->flashdata('error') != "") {
        ?>
        <div class="alert alert-danger">
            <h4><?php print $this->lang->line('message_error_heading'); ?></h4>
            <?php print $this->session->flashdata('error'); ?>
        </div>
    <?php
    }
    ?>
</div>
<div id="success" class="the_error">
    <?php
    if ($this->session->flashdata('success') != "") {
        ?>
        <div class="alert alert-success">
            <h4><?php print $this->lang->line('message_success_heading'); ?></h4>
            <?php print $this->session->flashdata('success'); ?>
        </div>
    <?php
    }
    ?>
</div>