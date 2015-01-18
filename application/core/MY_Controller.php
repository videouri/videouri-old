<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

    protected $_debug;

    public function __construct()
    {
        parent::__construct();

        $this->_debug['on'] = false;

        // Set the country key in user's session
        if (!$this->session->userdata('country')) {
            $this->load->helper('users');
            $this->session->set_userdata('country', getUserCountry());
        }

        #$this->output->enable_profiler(TRUE);
    }
}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */