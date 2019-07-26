<?php

	class App_model extends CI_Model
	{
		function __construct()
	    {
	        parent::__construct();

	        date_default_timezone_set('Europe/Madrid');

			$idioma = 'es';
			
			if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
				$idioma_usuario = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			else
				$idioma_usuario = 'es';

			$idiomas = $this->config->item('idiomas');

			if ($idioma == 'es')
				setlocale(LC_ALL, 'es_ES');

			$controlador = $this->uri->segment(1);

			// Guarda los valores y carga el idioma principal
			$this->lang->load('general', $idioma);
			$this->config->set_item('language', $idioma);
			$this->config->set_item('idioma', $idioma);

			$vars = array(
				'idioma' 		=> $idioma,
				'controlador' 	=> $controlador
			);
			$this->load->vars($vars);
	    }

	    function cargar($productos)
	    {
	    	$this->db->query('ALTER TABLE productos AUTO_INCREMENT = 1');

			foreach ($productos as $producto)
			{
				extract($producto);

				$insert = array(
					'nombre' 		=> $nombre,
					'codigo' 		=> $codigo,
					'precio' 		=> str_replace(',', '.', $precio),
					'descripcion' 	=> $descripcion
				);

				$this->db->insert('productos', $insert);
			}
	    }
	}

?>