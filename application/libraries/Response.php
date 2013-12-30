<?php

/**
 * Extends the 
 *
 * Adapted from Laravel to CI by Alexandru Budurovici 
 *
 * @see https://github.com/laravel/laravel/blob/3.0/laravel/response.php
 */
class Response
{
	public function __construct()
	{
		$CI =& get_instance();
		$CI->load->library('output');
	}

	/**
	 * Create a new JSON response.
	 *
	 * <code>
	 *		// Create a response instance with JSON
	 *		return Response::json($data, 200, array('header' => 'value'));
	 * </code>
	 *
	 * @param  mixed     $data
	 * @param  int       $status
	 * @param  array     $headers
	 * @param  int       $json_options
	 * @return Response
	 */
	public function json($data, $status = 200, $headers = array(), $json_options = 0)
	{
		$CI =& get_instance();
		$CI->output->set_content_type('application/json; charset=utf-8');

		foreach ($headers as $header) {
			$CI->output->set_header($header);
		}

		http_response_code($status);

        $CI->output->set_output(json_encode($data));
	}

	public function ok($message = true, $status = 200)
	{
		return Response::json($message, $status);
	}

	public function fail($message = false, $status = 400)
	{
		return Response::json($message, $status);
	}

}