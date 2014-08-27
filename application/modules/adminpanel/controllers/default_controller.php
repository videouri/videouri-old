<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Panel extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        redirect('adminpanel/list_members');
    }
}

/* End of file default_page.php */
/* Location: ./application/controllers/adminpanel/default_page.php */