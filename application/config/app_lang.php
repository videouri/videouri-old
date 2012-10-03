<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Default lang
|--------------------------------------------------------------------------
|
*/
$config['default_lang'] = 'en';

/*
|--------------------------------------------------------------------------
| Supported languages
|--------------------------------------------------------------------------
|
| Associative array of supported languages.
|
| Keys are URI lang code (ex : http://www.domain.com/en/...)
| Values are directories names within application/language  
|
*/
$config['available_lang'] = array(
	'en' => 'english',
	'fr' => 'french',
	'es' => 'spanish'
);

/*
|--------------------------------------------------------------------------
| Detect browser lang
|--------------------------------------------------------------------------
|
| Process browser lang detection if available.
| Default to TRUE.
|
*/
$config['detect_browser_lang'] = TRUE;

/*
|--------------------------------------------------------------------------
| Session name where URI lang code is stored
|--------------------------------------------------------------------------
|
| You can define any session name here.
| $config['kitlang_session_name'] = 'kitlang';
|
| If empty, session is inactive. Default to no session.
| $config['kitlang_session_name'] = '';  
|
*/
$config['lang_session_name'] = '';

