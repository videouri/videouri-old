<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Private_page extends Private_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    function index() {
        $this->template->set_theme(Settings_model::$db_config['active_theme']);
        $this->template->set_layout('main');
        $this->template->title('private page');
        $this->process_partial('header', 'private/header');
        $this->process_partial('footer', 'private/footer');
        $this->process_template_build('private/private_page');
    }

}

/* End of file private_page.php */
/* Location: ./application/controllers/private/private_page.php */