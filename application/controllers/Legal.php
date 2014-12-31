<?php defined('BASEPATH') OR exit("No direct script access allowed");

class Legal extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index($view)
    {
        if (!in_array($view, ['dmca', 'termsofuse']))
            redirect('/');

        $this->template->content->view('legal/'.$view);
        $this->template->publish();
    }
}