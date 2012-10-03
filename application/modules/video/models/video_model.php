<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('error');
    }

    function retrieveData($parameters = array())
    {
    	$api = $parameters['api'];
    	$id = $parameters['id'];
    }

}