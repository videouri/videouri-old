<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('hash_password')) {
    /**
     *
     * hash_password: obscure password with specially designed salt - site_key combo in sha512
     *
     * @param string $password the password to be validated
     * @param string $nonce the nonce that is unique to this member
     * @return string
     *
     */
    function hash_password($password, $nonce) {
        return hash_hmac('sha512', $password . $nonce, SITE_KEY);
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
            return geoip_country_code_by_name();
        }
        else {
            return 'UK';
        }
    }
    else {
        return geoip_country_code_by_name($ip);
    }
}


/* End of file users_helper.php */
/* Location: ./application/helpers/users_helper.php */