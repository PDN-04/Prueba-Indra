<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	function plantilla($vista, $datos = NULL)
	{
		$CI =& get_instance();

		$plantilla	= 'plantilla';
		$vista		= "{$vista}";

		$datos['body'] = $CI->load->view($vista, $datos, TRUE);

		$CI->load->view('plantilla', $datos);
	}

?>