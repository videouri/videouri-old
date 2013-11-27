<?php  if ( ! defined('BASEPATH')) exit("No direct script access allowed");

class Assets extends MX_Controller {

    public function getFont($name)
    {
        return base_url('assets/fonts/'.$name);
    }

}