<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends Private_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('role_id') != "1") {
            redirect("/private/no_access");
        }
		$this->load->model('adminpanel/adminpanel_model');
    }
	
	/**
     *
     * load_info_vars: load all variables that need to be displayed in the admin top bar
     *
     *
     */
	
	/*public function load_info_vars() {
		$this->load->model('adminpanel/adminpanel_model');
		$this->adminpanel_model->count_users();
	}*/
	
}

/* End of file Admin_Controller.php */
/* Location: ./application/core/Admin_Controller.php */