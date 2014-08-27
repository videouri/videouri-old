<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Caching settings */
$config['adapter'] = 'apc';
$config['backup']  = 'file';


/*
The reCaptcha server keys and API locations

Obtain your own keys from:
http://www.recaptcha.net
*/
$config['recaptcha'] = array(
  'public'=>'',
  'private'=>'',
  'RECAPTCHA_API_SERVER' =>'http://www.google.com/recaptcha/api',
  'RECAPTCHA_API_SECURE_SERVER'=>'https://www.google.com/recaptcha/api',
  'RECAPTCHA_VERIFY_SERVER' =>'www.google.com',
  'RECAPTCHA_SIGNUP_URL' => 'https://www.google.com/recaptcha/admin/create',
  'theme' => Settings_model::$db_config['recaptcha_theme']
);

//  Settings_model::$db_config

$config['members_per_page']    = 20;
$config['admin_email_address'] = "contact@videouri.com";

##
# Mail Config
##

# 1 - PHP mail()
# 2 - Sendmail()
# 3 - Gmail smtp
$config['email_protocol'] = 2;

$config['sendmail_path'] = '/usr/sbin/sendmail';
$config['smtp_host'] = 'ssl://smtp.googlemail.com';
$config['smtp_port'] = 465;
$config['smtp_user'] = '';
$config['smtp_pass'] = '';

##
# Expire settings
##
$config['cookie_expires']          = 259200; # 3 Days
$config['password_link_expires']   = 43200;  # 12 Hours
$config['activation_link_expires'] = 43200;  # 12 Hours

##
#  - Deny access to all pages, both public and private. The main administrator account will still be able to log in.
#  - Disabled site message
##
$config['disable_all']        = false;
$config['site_disabled_text'] = 'Site disabled.';

##
# Register & Login related configs
##
$config['login_home_page']      = 'dashboard';
$config['login_enabled']        = true;
$config['login_attempts']       = 5;
$config['registration_enabled'] = true;
$config['remember_me_enabled']  = true;

##
# Captcha
##
$config['recaptcha_enabled'] = true;
$config['recaptcha_theme']   = 'white';

/* security site key used for password encryption */
define('SITE_KEY', 'putyourowncreatedsitekeyhereforsecurity');

// Login script: administrator account name
define('ADMINISTRATOR', "administrator");

/* End of file app_settings.php */
/* Location: ./application/config/app_settings.php */