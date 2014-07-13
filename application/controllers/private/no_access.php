<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class No_access extends Private_Controller {

    public function __construct ()
    {
        parent::__construct();
    }

    public function index() {
        $this->template->set_theme(Settings_model::$db_config['active_theme']);
        $this->template->set_layout('main');
        $this->template->title($this->lang->line('my_profile'));
        $this->process_partial('header', 'private/header');
        $this->process_partial('footer', 'private/footer');
        $this->process_template_build('private/no_access');
    }
}

/* End of file no_access.php */
/* Location: ./application/controllers/private/no_access.php */