<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('load_email_config')) {
    /**
     *
     * load_email_config: obscure password with specially designed salt - site_key combo in sha512
     *
     * @param int $i the config type: 1 = PHP mail(); 2 = sendmail; 3 = SMTP
     * @return array
     *
     */
    function load_email_config($i) {
        $CI = & get_instance();
        $CI->load->library('encrypt');
        $config = array();
        switch ($i) {
            case 2:
                $config = array(
                    'protocol' => 'sendmail',
                    'mailpath' => $this->config->item('sendmail_path'),
                    'charset' => "utf-8",
                    'wordwrap' => TRUE,
                    'newline' => "\r\n"
                );
                break;
            case 3:
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => $this->config->item('smtp_host'),
                    'smtp_port' => $this->config->item('smtp_port'),
                    'smtp_user' => $CI->encrypt->decode($this->config->item('smtp_user')),
                    'smtp_pass' => $CI->encrypt->decode($this->config->item('smtp_pass')),
                    'smtp_timeout' => 30,
                    'charset' => "utf-8",
                    'newline' => "\r\n"
                );
        }

        return $config;
    }
}

/* End of file send_email_helper.php */
/* Location: ./application/helpers/send_email_helper.php */