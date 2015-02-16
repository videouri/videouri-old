<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Errors controller
 *
 */
class Errors extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($error)
    {
        if (!in_array($error, ['404']))
            redirect('/');

        $this->output->set_status_header('404'); 
        $this->template->bodyId = 'error';
        $this->template->content->view('errors/html/error_'.$error);
        $this->template->publish();
    }
}