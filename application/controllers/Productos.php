<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Productos extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();

			$this->controlador = $this->uri->segment(1);
		}

		function index()
		{
			$this->listado();
		}

		function listado()
		{
			$cargar = $this->db->get($this->controlador)->num_rows();

			$busqueda = $this->input->post('busqueda');

			$campo_orden	= $this->input->post('campo_orden');
			$tipo_orden		= $this->input->post('tipo_orden');

			if ($busqueda != '')
			{
				$this->db->like('nombre', $busqueda);
				$this->db->or_like('codigo', $busqueda);
				$this->db->or_like('descripcion', $busqueda);
			}

			if ($campo_orden != '' && $tipo_orden != '')
				$this->db->order_by($campo_orden, $tipo_orden);

			$rs = $this->db->get($this->controlador);

			$datos = array(
				'cargar' 		=> $cargar,
				'busqueda' 		=> $busqueda,
				'campo_orden' 	=> $campo_orden,
				'tipo_orden' 	=> $tipo_orden,
				'rs' 			=> $rs,

				'nombre_pagina' => lang('productos')
			);

			plantilla("{$this->controlador}/listado", $datos);
		}

		function cargar()
		{
			$fichero 	= file_get_contents("resources/{$this->controlador}/{$this->controlador}.json");
			$productos 	= json_decode($fichero, true)['productos'];

			$this->app_model->cargar($productos);

			redirect($this->agent->referrer());
		}
	}

?>