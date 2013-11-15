<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

    
    if( !function_exists('curl_get'))
    {
        function curl_get($url)
        {
            // Initiate the curl session
            $ch = curl_init();

            // Set the URL
            curl_setopt($ch, CURLOPT_URL, $url);

            // Removes the headers from the output
            curl_setopt($ch, CURLOPT_HEADER, 0);

            // Return the output instead of displaying it directly
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

            // Execute the curl session
            $output = curl_exec($ch);

            // Return headers
            $headers = curl_getinfo($ch);
            
            // Close the curl session
            curl_close($ch);

            return $output;
        }
    }

    
    if( !function_exists('trim_text')) {

        function trim_text($input, $length, $lbreaks = true, $ellipses = true, $strip_html = true, $output_entities = true)
        {

            // Strip tags, if desired
            if($strip_html) {
                $input = strip_tags($input);
            }
         
            // No need to trim, already shorter than trim length
            if(strlen($input) <= $length) {
                return $input;
            }

            if( ! $lbreaks) {
                $elements = array(
                    "\n", "\n\r", "\n\t",
                    "\r", "\r\n", "\r\t",
                    "\t", "\t\n", "\t\r"
                );
                $input = str_replace($elements, '', $input);
                
                $input = preg_replace('/[ ]+/', ' ', $input);
                $input = preg_replace('/<!--[^-]*-->/', '', $input);
            }
         
            // Find last space within length
            $last_space = strrpos(substr($input, 0, $length), ' ');
            $trimmed_text = substr($input, 0, $last_space);

             // Add ellipses (...)
            if($ellipses){
                $trimmed_text .= '...';
            }
         
            if($output_entities){
                $trimmed_text = htmlentities($trimmed_text);
            }
         
            return $trimmed_text;

        }

    }