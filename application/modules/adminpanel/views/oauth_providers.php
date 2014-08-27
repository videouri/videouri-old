<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

    <h1 class="page-title"><?php print $this->lang->line('oauth_providers'); ?></h1>

    <?php $this->load->view('generic/flash_error'); ?>

    <?php if (!empty($providers)) { ?>

    <p>
        <a href="<?php print base_url(); ?>adminpanel/oauth_new_provider" class="btn btn-default">Add new</a>
    </p>

    <p><strong>The name must be exactly the same as the provider for example "google", not "google+".</strong></p>
<div id="mainbrol">
    <table  class="table table-hover">
        <thead>
        <tr>
            <th><?php print $this->lang->line('provider_name'); ?></th>
            <th><?php print $this->lang->line('consumer_key'); ?></th>
            <th><?php print $this->lang->line('consumer_secret'); ?></th>
            <th><?php print $this->lang->line('provider_enabled'); ?></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($providers as $provider) { ?>

            <?php print form_open('adminpanel/oauth_providers/action') ."\r\n"; ?>

            <tr>
                <td><input type="text" name="name" class="form-control" value="<?php print $provider->name; ?>"></td>
                <td><input type="text" name="key" class="form-control" value="<?php print $provider->key; ?>"></td>
                <td><input type="text" name="secret" class="form-control" value="<?php print $provider->secret; ?>"></td>
                <td>
                    <select name="enabled" class="form-control">
                        <option value="1"<?php print ($provider->enabled == true ? ' selected="selected"' : ''); ?>>Yes</option>
                        <option value="0"<?php print ($provider->enabled == false ? ' selected="selected"' : ''); ?>>No</option>
                    </select>
                </td>
                <td>
                    <input type="submit" name="save" value="Save" class="message_cleanup btn btn-primary">
                </td>
                <td>
                    <input type="submit" name="delete" value="<?php print $this->lang->line('provider_delete'); ?>" class="btn btn-danger">
                    <input type="hidden" name="id" value="<?php print $provider->id; ?>">
                </td>
            </tr>

            <?php print form_close() ."\r\n"; ?>

        <?php } ?>

        </tbody>
    </table>
</div>
    <?php } ?>