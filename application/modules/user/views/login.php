<section>

    <div class="row">
        <div class="col-lg-4 col-sm-6 col-xs-8 center-box clearfix">
            <?php if ($this->config->item('login_enabled') == 0): ?>
                <div id="error" class="alert alert-danger">
                    <p> <?= $this->lang->line('login_disabled') ?></p>
                </div>
            <?php else: ?>
                <?php $this->load->view('generic/flash_error'); ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 center-box clearfix">
            <ul id="oauth-container" class="list-inline text-center">
                <li>
                    <a href="<?= base_url(); ?>user/auth/oauth2/facebook" class="social-icon-facebook">
                        <i class="fa fa-facebook-square fa-5x"></i>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url(); ?>user/auth/oauth2/google" class="social-icon-google">
                        <i class="fa fa-google-plus-square fa-5x"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
        
    <div class="row">
        <div class="col-lg-12 clearfix center-box">

            <?= form_open('membership/login/validate', 'id="login-form" class="regular_form"') ."\r\n"; ?>
            
            <div class="form-group">
                <input type="text" name="username" id="username" class="form-control tooltip_target"
                       placeholder="<?= $this->lang->line('username'); ?>"
                       data-toggle="tooltip" data-original-title="<?= $this->lang->line('username_requirements'); ?>">
            </div>
            
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control tooltip_target"
                       placeholder="<?= $this->lang->line('password'); ?>"
                       data-toggle="tooltip" data-original-title="<?= $this->lang->line('password_requirements'); ?>">
            </div>

            <!-- <div class="form-group">
                <?php if ($this->config->item('remember_me_enabled') == true) { ?>
                <p>
                    <label for="remember_me"><?= $this->lang->line('remember_me'); ?></label>
                    <?= form_checkbox(array('name' => 'remember_me', 'id' =>'remember_me', 'value' => 'accept', 'checked' => FALSE)); ?>
                </p>
                <?php } ?>
            </div> -->
            
            <div class="recaptcha-wrapper">
                <?php if ($this->session->userdata('login_attempts') > 5): ?>
                    <?= $this->recaptcha->get_html(); ?>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <input type="submit" name="submit" value="<?= $this->lang->line('signin'); ?>" class="btn btn-primary btn-loading">
            </div>

            <?= form_close() ."\r\n"; ?>
        </div>
            
    </div>
</section>