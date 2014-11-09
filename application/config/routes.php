<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package     CodeIgniter
 * @author      EllisLab Dev Team
 * @copyright   Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @license     http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link        http://codeigniter.com
 * @since       Version 1.0
 * @filesource
 */

$route['default_controller'] = 'home';

#$route['api/videos']['get']  = "resources/api/getVideos";

$route['user/([a-zA-Z_-]+)']['get'] = "user/get".ucfirst("$1");
$route['signin']['get']      = "user/getLogin";

$route['video/(.+)$']['get'] = "video/id/$1";
#$route['results$']    = "fetch/results$1";
$route['results']['get' ]    = "fetch/results";
$route['tag/(:any)']['get']  = "fetch/results?search_query=$1&search=tag";

$route['404_override']         = '';
$route['translate_uri_dashes'] = FALSE;

/* End of file routes.php */
/* Location: ./application/config/routes.php */