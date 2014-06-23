<?php defined('BASEPATH') OR exit('No direct script access allowed');

    if ( ! function_exists('results_validate'))
    {
        function results_validate($api, $data)
        {
        	switch ($api) {
        		case 'youtube':

    			break;
        		
        		case 'vimeo':
        			if($data['stat'] == 'fail')
        			{
        				return false;
        			}
    			break;
        	}
        }
    }