<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Inicio extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
		}

		function index()
		{
			$datos = array(
				'nombre_pagina' => lang('inicio')
			);

			plantilla('inicio', $datos);
		}

		function reiniciar()
		{	
			$this->db->where('id_cliente >', 0);		
			$this->db->delete('clientes');

			$this->db->query('ALTER TABLE clientes AUTO_INCREMENT = 1');

			$this->db->where('id_producto >', 0);					
			$this->db->delete('productos');

			$this->db->query('ALTER TABLE productos AUTO_INCREMENT = 1');

			redirect($this->agent->referrer());
		}
	}

?>