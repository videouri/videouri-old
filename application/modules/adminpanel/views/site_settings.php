<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

    <h1 class="page-title">Site settings</h1>

    <?php $this->load->view('generic/flash_error'); ?>

    <?php print form_open('adminpanel/site_settings/update_settings', array('id' => 'settings_form')) ."\r\n"; ?>

    <h2>General settings</h2>

    <p>
        <input type="submit" name="site_settings_submit_top" value="Save all settings" class="btn btn-primary message_cleanup">
    </p>
	
	<div class="form-group clearfix">
		<label for="site_title">Site title</label>
		<p>The site title appears in the title bar as it is used in the <code>&lt;title&gt;</code> tag. Can be a maximum of 60 characters long.</p>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="site_title" id="site_title" class="form-control" value="<?php print Settings_model::$db_config['site_title']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="disable_all" class="inline">Disable whole application</label>
		<input type="checkbox" name="disable_all" id="disable_all" value="accept"<?php print (Settings_model::$db_config['disable_all'] == 1 ? ' checked="checked"' : ""); ?>>
        <p>Deny access to all pages, both public and private. The main administrator account will still be able to log in.</p>
	</div>
	
	<div class="form-group clearfix">
		<label for="site_disabled_text">Text to display when website is disabled:</label><br>
        <textarea name="site_disabled_text" id="site_disabled_text" class="form-control col-lg-12"><?php print Settings_model::$db_config['site_disabled_text']; ?></textarea>
	</div>
	
	<div class="form-group clearfix">
		<label for="login_enabled" class="inline">Disable login access</label>
        <input type="checkbox" name="login_enabled" id="login_enabled" value="accept"<?php print (Settings_model::$db_config['login_enabled'] == 0 ? ' checked="checked"' : ""); ?>>
        <p>Turn off login ability for all members except the main administrator account.</p>
	</div>

	<div class="form-group clearfix">
		<label for="register_enabled" class="inline">Disable member registration</label>
        <input type="checkbox" name="register_enabled" id="register_enabled" value="accept"<?php print (Settings_model::$db_config['registration_enabled'] == 0 ? ' checked="checked"' : ""); ?>>
        <p class="form_subtext">Turn off the ability for new people to register on the site.</p>
	</div>
	
	<div class="form-group clearfix">
		<label for="recaptcha_enabled" class="inline">Enable recaptcha</label>
        <input type="checkbox" name="recaptcha_enabled" id="recaptcha_enabled" value="accept"<?php print (Settings_model::$db_config['recaptcha_enabled'] == 1 ? ' checked="checked"' : ""); ?>>
        <p>Turn on recaptcha site-wide to better protect the membership module.</p>
	</div>
	
	<div class="form-group clearfix">
		<label for="remember_me_enabled" class="inline">Enable remember me</label>
        <input type="checkbox" name="remember_me_enabled" id="remember_me_enabled" value="accept"<?php print (Settings_model::$db_config['remember_me_enabled'] == 1 ? ' checked="checked"' : ""); ?> class="label_checkbox">
        <p>Allow the remember me functionality to be used on the login page (based on cookies).</p>
	</div>
	
	<div class="form-group clearfix">
		<label for="install_enabled" class="inline">Enable install page</label>
        <input type="checkbox" name="install_enabled" id="install_enabled" value="accept"<?php print (Settings_model::$db_config['install_enabled'] == 1 ? ' checked="checked"' : ""); ?> class="label_checkbox">
        <p>Turn on the installation page, is used to recreate the main administrator account.</p>
	</div>
	
	<div class="form-group clearfix">
		<label for="members_per_page">Members per page</label>
        <p>The number of members per page to display on the list members page.</p>
        <div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
				<input type="text" name="members_per_page" id="members_per_page" class="form-control" value="<?php print Settings_model::$db_config['members_per_page']; ?>" maxlength="3">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="admin_email">Administrator e-mail account</label>
        <p>Primary application e-mail address to be used for sending e-mails - by default the same as the main administrator e-mail.</p>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="admin_email" id="admin_email" class="form-control" value="<?php print Settings_model::$db_config['admin_email_address']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="home_page">Post-login display page</label>
        <p>The page to display right after logging in - should be a controller that extends Private_Controller.</p>
        <div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<?php print form_dropdown('home_page', $private_pages, Settings_model::$db_config['home_page'], 'class="form-control"'); ?>
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="active_theme">Currently active theme</label>
        <p>Allows for change of admin folder by selecting the corresponding theme folder name.</p>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="active_theme" id="active_theme" class="form-control" value="<?php print Settings_model::$db_config['active_theme']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="login_attempts">ReCaptcha login attempts trigger</label>
        <p>Shows a reCaptcha form after this many failed login attempts.</p>
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-8 clearfix">
				<input type="text" name="login_attempts" id="login_attempts" class="form-control" value="<?php print Settings_model::$db_config['login_attempts']; ?>" maxlength="3">
			</div>
		</div>
	</div>
	<div class="form-group clearfix">
		<label for="recaptcha_theme">ReCaptcha theme</label>
        <p>Choose the preferred reCaptcha view style.</p>
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-8 clearfix">
				<input type="text" name="recaptcha_theme" id="recaptcha_theme" class="form-control" value="<?php print Settings_model::$db_config['recaptcha_theme']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="cookie_exp">Cookie expiration</label>
        <p>Cookies set will receive this number in seconds as their future expiry time.</p>
        <div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-8 clearfix">
				<input type="text" name="cookie_exp" id="cookie_exp" class="form-control" value="<?php print Settings_model::$db_config['cookie_expires']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="password_exp">Password link expiration</label>
        <p>Make the reset password activation link expire in this many seconds in the future.</p>
        <div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-8 clearfix">
				<input type="text" name="password_exp" id="password_exp" class="form-control" value="<?php print Settings_model::$db_config['password_link_expires']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="activation_exp">Activation link expiration</label>
        <p>Make the account activation link expire in this many seconds in the future.</p>
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-8 clearfix">
				<input type="text" name="activation_exp" id="activation_exp" class="form-control" value="<?php print Settings_model::$db_config['activation_link_expires']; ?>">
			</div>
		</div>
	</div>
	
	<div>
        <input type="submit" name="site_settings_submit_top" value="Save all settings" class="btn btn-primary message_cleanup">
    </div>
	
	<h2>Mail settings</h2>
	
	<div class="form-group clearfix">
		<label>Protocol</label>
        <p>
            PHP mail() &raquo; <input type="radio" name="email_protocol" value="1" class="label_checkbox"<?php print (Settings_model::$db_config['email_protocol'] == 1 ? ' checked="checked"' : ""); ?>><br>
            Sendmail &raquo; <input type="radio" name="email_protocol" value="2" class="label_checkbox"<?php print (Settings_model::$db_config['email_protocol'] == 2 ? ' checked="checked"' : ""); ?>><br>
            Gmail SMTP &raquo; <input type="radio" name="email_protocol" value="3" class="label_checkbox"<?php print (Settings_model::$db_config['email_protocol'] == 3 ? ' checked="checked"' : ""); ?>><br>
        </p>
	</div>
	
	<div class="form-group clearfix">
		<label for="sendmail_path">Path to sendmail</label>
        <p>For most servers this is /usr/sbin/sendmail</p>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="sendmail_path" id="sendmail_path" class="form-control" value="<?php print Settings_model::$db_config['sendmail_path']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="smtp_host">SMTP host</label>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="smtp_host" id="smtp_host" class="form-control" value="<?php print Settings_model::$db_config['smtp_host']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="smtp_port">SMTP port</label>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="smtp_port" id="smtp_port" class="form-control" value="<?php print Settings_model::$db_config['smtp_port']; ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="smtp_user">SMTP user</label>
        <p>Will be encrypted before saving to database.</p>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="smtp_user" id="smtp_user" class="form-control" value="<?php print $this->encrypt->decode(Settings_model::$db_config['smtp_user']); ?>">
			</div>
		</div>
	</div>
	
	<div class="form-group clearfix">
		<label for="smtp_pass">SMTP password</label>
        <p>Will be encrypted before saving to database.</p>
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 clearfix">
				<input type="text" name="smtp_pass" id="smtp_pass" class="form-control" value="<?php print $this->encrypt->decode(Settings_model::$db_config['smtp_pass']); ?>">
			</div>
		</div>
	</div>
	
	<p>
        <input type="submit" name="site_settings_submit_top" value="Save all settings" class="btn btn-primary message_cleanup">
    </p>

    <?php
    print form_close() ."\r\n";

    print form_open('adminpanel/site_settings/clear_sessions', array('id' => 'sessions_form')) ."\r\n";
    if ($this->session->flashdata('sessions_message')) {
        print '<div id="error" class="error_box">'. $this->session->flashdata('sessions_message') ."</div>\r\n";
    }
    ?>

    <h2>Clear your sessions</h2>

    <p>
        Can be used to gracefully make all members log out by removing their session data.
    </p>

    <p>
        <input type="submit" name="sessions_submit" id="sessions_submit" value="Clear sessions" class="btn btn-primary message_cleanup">
    </p>

<?php print form_close() ."\r\n";