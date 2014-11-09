<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row">
    
        <?php $this->load->view('themes/bootstrap3/membership/oauth'); ?>
    
        <div class="col-lg-6 col-sm-6 col-xs-8 form-container center-box">
            
            <div>
                <?php if ($this->config->item('registration_enabled')): ?>
                    <div id="error" class="alert alert-danger">
                        <?php print $this->lang->line('registration_disabled'); ?>
                    </div>
                <?php else: ?>
                    <?php $this->load->view('generic/flash_error'); ?>
                <?php endif; ?>
                ?>
            </div>
            
            <div id="regular_wrapper">
                <div id="oauth_login_wrapper">
                    <p class="text-center">
                        <a id="oauth_login" class="btn btn-default" href="javascript:"><?php print $this->lang->line('go_to_social_login'); ?></a>
                    </p>
                </div>
                
                <?php print form_open('membership/register/add_member','id="register_form" class="regular_form"') ."\r\n"; ?>
                
                <p>
                    (All fields are required)
                </p>
                
                <div class="form-group">
                    <label for="reg_first_name"><?php //print $this->lang->line('first_name'); ?></label>
                    <input type="text" name="first_name" id="reg_first_name" class="form-control tooltip_target" placeholder="<?php print $this->lang->line('first_name'); ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('first_name_requirements'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="reg_last_name"><?php //print $this->lang->line('last_name'); ?></label>
                    <input type="text" name="last_name" id="reg_last_name" class="form-control tooltip_target" placeholder="<?php print $this->lang->line('last_name'); ?>" value="<?php print $this->session->flashdata('last_name'); ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('last_name_requirements'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="reg_email"><?php //print $this->lang->line('email_address'); ?></label>
                    <input type="text" name="email" id="reg_email" class="form-control tooltip_target" placeholder="<?php print $this->lang->line('email_address'); ?>" value="<?php print $this->session->flashdata('email'); ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('email_requirements'); ?>">
                </div>
                
                <ul id="email_verification_box" class="list-unstyled">
                    <li><div id="email_valid"></div></li>
                    <li><div id="email_taken"></div></li>
                </ul>
                
                <div class="form-group">
                    <label for="reg_username"><?php //print $this->lang->line('username'); ?></label>
                    <input type="text" name="username" id="reg_username" class="form-control tooltip_target" placeholder="<?php print $this->lang->line('username'); ?>" value="<?php print $this->session->flashdata('username'); ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('username_requirements'); ?>">
                </div>
                
                <div>
                    <div id="username_valid"></div>
                    <div id="username_taken"></div>
                    <div id="username_length"></div>
                </div>
                
                <div class="form-group">
                    <label for="reg_password"><?php //print $this->lang->line('password'); ?></label>
                    <input type="password" name="password" id="reg_password" class="form-control tooltip_target" placeholder="<?php print $this->lang->line('password'); ?>" value="<?php print $this->session->flashdata('password'); ?>" data-toggle="tooltip" data-original-title="<?php print $this->lang->line('password_requirements'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="password_confirm"><?php //print $this->lang->line('confirm_password'); ?></label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="<?php print $this->lang->line('confirm_password'); ?>" value="<?php print $this->session->flashdata('password_confirm'); ?>">
                </div>
                
                <div class="recaptcha-wrapper">
                    <?= $this->recaptcha->get_html(); ?>
                </div>
                
                <div class="form-group">
                    <input type="submit" name="membership_submit" id="membership_submit" value="<?php print $this->lang->line('signup'); ?>" class="btn btn-primary btn-loading">
                    <span class="loading"><img src="<?php print base_url(); ?>images/loaderB16.gif" alt=""></span>
                </div>

                <?php print form_close() ."\r\n"; ?>
            </div>
            
        </div>
        
    </div>
</div>

