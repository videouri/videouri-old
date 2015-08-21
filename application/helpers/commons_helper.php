<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Recursive in_array function
 *
 * @param  array $needle
 * @param  array $haystack
 * @return boolean
 */
function in_array_r($needle, $haystack)
{
    if (!is_array($needle)) {
        return in_array_r(array($needle), $haystack);
    }

    foreach ($needle as $item) {
        if (in_array($item, $haystack)) {
            return true;
        }
    }

    return false;
}

/**
 * Humanize numbers.
 * For example: 5000 would become 5K
 *
 * @param  int $number
 * @return return string
 */
function humanizeNumber($number)
{
    $abbrevs = array(12 => "T", 9 => "B", 6 => "M", 3 => "K", 0 => "");

    foreach($abbrevs as $exponent => $abbrev) {
        if($number >= pow(10, $exponent)) {
            $display_num = $number / pow(10, $exponent);
            $decimals = ($exponent >= 3 && round($display_num) < 100) ? 1 : 0;
            return number_format($display_num,$decimals) . $abbrev;
        }
    }
}

function humanizeSeconds($seconds)
{
    if ($seconds > 86400) {
        $seconds = $seconds % 86400;
    }

    return gmdate('H:i:s', $seconds);
}

/**
 * Used to order an array, by it's viewsCount
 *
 * @param  [type] $a [description]
 * @param  [type] $b [description]
 * @return [type]    [description]
 */
function sortByViews($a, $b)
{
    if ($a['viewsCount'] === null)
        $a['viewsCount'] = 0;

    if ($b['viewsCount'] === null)
        $b['viewsCount'] = 0;

    return $b['viewsCount'] - $a['viewsCount'];
}


function parseLinks($text)
{
    // The Regular Expression filter
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

    // Check if there is a url in the text
    if(preg_match($reg_exUrl, $text, $url)) {
       // make the urls hyper links
       echo preg_replace($reg_exUrl, '<a href="' . $url[0] . '" target="_blank">' . $url[0] . '</a>', $text);
    } else {
       // if no urls in the text just return the text
       echo $text;
    }
}


function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}


if( !function_exists('curl_get'))
{
    function curl_get($url)
    {
        // Initiate the curl session
        $ch = curl_init();

        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $url);

        // Removes the headers from the output
        curl_setopt($ch, CURLOPT_HEADER, 0);

        #curl_setopt($ch, CURLOPT_VERBOSE, true);

        // Return the output instead of displaying it directly
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        // Execute the curl session
        $output = curl_exec($ch);

        // Return headers
        $headers = curl_getinfo($ch);

        // Close the curl session
        curl_close($ch);

        var_dump($headers);
        var_dump($output);

        return $output;
    }
}


if( !function_exists('trim_text')) {

    function trim_text($input, $length, $lbreaks = true, $ellipses = true, $strip_html = true, $output_entities = true)
    {

        // Strip tags, if desired
        if($strip_html) {
            $input = strip_tags($input);
        }

        // No need to trim, already shorter than trim length
        if(strlen($input) <= $length) {
            return $input;
        }

        if( ! $lbreaks) {
            $elements = array(
                "\n", "\n\r", "\n\t",
                "\r", "\r\n", "\r\t",
                "\t", "\t\n", "\t\r"
            );
            $input = str_replace($elements, '', $input);

            $input = preg_replace('/[ ]+/', ' ', $input);
            $input = preg_replace('/<!--[^-]*-->/', '', $input);
        }

        // Find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);

         // Add ellipses (...)
        if($ellipses){
            $trimmed_text .= '...';
        }

        if($output_entities){
            $trimmed_text = htmlentities($trimmed_text);
        }

        return $trimmed_text;

    }

}



/**
 * Try and get the acurrate IP
 * @return string IP
 */
function getUserIPAdress()
{
    //check ip from share internet
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }

    //to check ip is pass from proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}


/**
 * Return user's country, based on his IP
 * @return string Country
 */
function getUserCountry($ip = null)
{
    if (empty($ip)) {
        $ip = getUserIPAdress();

        if ($ip !== '127.0.0.1') {
            return geoip_country_code_by_name($ip);
        }

        return 'UK';
    }

    return geoip_country_code_by_name($ip);
}


/* End of file users_helper.php */
/* Location: ./application/helpers/users_helper.php */