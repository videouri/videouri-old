<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membership_Controller extends Public_Controller
{
    public function __construct ()
    {
        parent::__construct();

        if (!empty($this->session->userdata('logged_in'))) {
            redirect('private/'. $this->config->item('app_settings', 'home_page'));
        }
    }
}

/* End of file Membership_Controller.php */
/* Location: ./application/core/Membership_Controller.php */
