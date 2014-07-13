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

/* security site key used for password encryption */
define('SITE_KEY', 'putyourowncreatedsitekeyhereforsecurity');

// Login script: administrator account name
define('ADMINISTRATOR', "administrator");

/* End of file app_settings.php */
/* Location: ./application/config/app_settings.php */