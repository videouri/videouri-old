<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Debug Helper
*
* http://philsturgeon.co.uk/blog/2010/09/power-dump-php-applications
* 
* Outputs the given variable(s) with formatting and location
*
* @access        public
* @param        mixed    variables to be output
*/

if( !function_exists('dump'))
{
    function dump()
    {
        list($callee) = debug_backtrace();
        $arguments = func_get_args();
        $total_arguments = count($arguments);

        echo '<fieldset style="background: #fefefe !important; border:2px red solid; padding:5px">';
        echo '<legend style="background:lightgrey; padding:5px;">'.$callee['file'].' @ line: '.$callee['line'].'</legend><pre>';
        $i = 0;
        foreach ($arguments as $argument)
        {
            echo '<br/><strong>Debug #'.(++$i).' of '.$total_arguments.'</strong>: ';
            var_dump($argument);
        }

        echo "</pre>";
        echo "</fieldset>";
    }
}

if ( ! function_exists('prePrint')) {
    function prePrint($data, $message = '')
    {
        if (!empty($message)) echo '<br/>'.$message.'<br/>';
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}

if ( ! function_exists('preDump')) {
    function preDump($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}

if ( ! function_exists('dd')) {
    function dd($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die;
    }
}