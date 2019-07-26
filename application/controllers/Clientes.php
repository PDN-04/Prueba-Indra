<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Clientes extends CI_Controller
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
			$busqueda = $this->input->post('busqueda');

			$campo_orden	= $this->input->post('campo_orden');
			$tipo_orden		= $this->input->post('tipo_orden');

			if ($busqueda != '')
			{
				$this->db->like('nombre', $busqueda);
				$this->db->or_like('apellidos', $busqueda);
				$this->db->or_like('dni', $busqueda);
				$this->db->or_like('email', $busqueda);
			}

			if ($campo_orden != '' && $tipo_orden != '')
				$this->db->order_by($campo_orden, $tipo_orden);

			$rs = $this->db->get($this->controlador);

			$datos = array(
				'busqueda' 		=> $busqueda,
				'campo_orden' 	=> $campo_orden,
				'tipo_orden' 	=> $tipo_orden,
				'rs' 			=> $rs,

				'nombre_pagina' => lang('clientes')
			);

			plantilla("{$this->controlador}/listado", $datos);
		}

		function nuevo()
		{
			$config = array(
				array(
					'field' => 'nombre',
					'label' => lang('campo.nombre'),
					'rules' => 'required'
				),
				array(
					'field' => 'dni',
					'label' => lang('campo.dni'),
					'rules' => 'required'
				),
				array(
					'field' => 'email',
					'label' => lang('campo.email'),
					'rules' => 'required'
				)
			);

			$this->form_validation->set_rules($config);

			$nombre 	= trim($this->input->post('nombre'));
			$apellidos 	= trim($this->input->post('apellidos'));
			$dni 		= trim($this->input->post('dni'));
			$direccion 	= trim($this->input->post('direccion'));
			$telefono 	= trim($this->input->post('telefono'));
			$email 		= trim($this->input->post('email'));

			$datos = array(
				'nombre' 		=> $nombre,
				'apellidos' 	=> $apellidos,
				'dni' 			=> $dni,
				'direccion' 	=> $direccion,
				'telefono' 		=> $telefono,
				'email' 		=> $email,

				'nombre_pagina' => lang('clientes')
			);

			if ($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<li>', '</li>');

	        	plantilla("{$this->controlador}/nuevo", $datos);
			}
			else
			{
				$insert = array(
					'nombre' 		=> $nombre,
					'apellidos' 	=> $apellidos,
					'dni' 			=> $dni,
					'direccion' 	=> $direccion,
					'telefono' 		=> $telefono,
					'email' 		=> $email
				);

				$this->db->insert($this->controlador, $insert);

				redirect($this->controlador);
			}
		}

		function editar($id = null)
		{
			if (is_numeric($id))
			{
				$config = array(
					array(
						'field' => 'nombre',
						'label' => lang('campo.nombre'),
						'rules' => 'required'
					),
					array(
						'field' => 'dni',
						'label' => lang('campo.dni'),
						'rules' => 'required'
					),
					array(
						'field' => 'email',
						'label' => lang('campo.email'),
						'rules' => 'required'
					)
				);

				$this->form_validation->set_rules($config);

				$nombre 	= trim($this->input->post('nombre'));
				$apellidos 	= trim($this->input->post('apellidos'));
				$dni 		= trim($this->input->post('dni'));
				$direccion 	= trim($this->input->post('direccion'));
				$telefono 	= trim($this->input->post('telefono'));
				$email 		= trim($this->input->post('email'));

				$this->db->where('id_cliente', $id);
				$rs = $this->db->get('clientes');

				if ($rs->num_rows() == 0)
					redirect($this->controlador);
				
				if (sizeof($_POST) == 0)
				{
					$fila = $rs->row_array();

					$nombre 	= $fila['nombre'];
					$apellidos 	= $fila['apellidos'];
					$dni 		= $fila['dni'];
					$direccion 	= $fila['direccion'];
					$telefono 	= $fila['telefono'];
					$email 		= $fila['email'];
				}

				$datos = array(
					'nombre' 		=> $nombre,
					'apellidos' 	=> $apellidos,
					'dni' 			=> $dni,
					'direccion' 	=> $direccion,
					'telefono' 		=> $telefono,
					'email' 		=> $email,

					'nombre_pagina' => lang('clientes')
				);

				if ($this->form_validation->run() == FALSE)
				{
					$this->form_validation->set_error_delimiters('<li>', '</li>');

		        	plantilla("{$this->controlador}/editar", $datos);
				}
				else
				{
					$update = array(
						'nombre' 	=> $nombre,
						'apellidos' => $apellidos,
						'dni' 		=> $dni,
						'direccion' => $direccion,
						'telefono' 	=> $telefono,
						'email' 	=> $email
					);

					$this->db->where('id_cliente', $id);
					$this->db->update($this->controlador, $update);

					redirect($this->controlador);
				}
			}
			else
				redirect($this->controlador);
		}

		function borrar($id = null)
		{
			if (is_numeric($id))
			{
				$this->db->where('id_cliente', $id);
				$this->db->delete('clientes');
			}

			redirect($this->controlador);
		}

		function relacionar($id = null)
		{
			if (is_numeric($id))
			{
				$busqueda = $this->input->post('busqueda');
				
				if ($busqueda != '')
					$this->db->like('nombre', $busqueda);
					
				$rs = $this->db->get('productos');

				$this->db->where('id_cliente', $id);
				$cliente = $this->db->get('clientes')->row_array();

				$this->db->join('productos', 'productos.id_producto = clientes_productos.id_producto', 'INNER');
				$this->db->where('id_cliente', $id);
				$rs_relacionados = $this->db->get('clientes_productos');

				$relacionados = array();
				foreach ($rs_relacionados->result_array() as $fila)
					$relacionados[$fila['id_producto']] = $fila['nombre'];

				$datos = array(
					'id' 			=> $id,

					'busqueda' 		=> $busqueda,
					'rs' 			=> $rs,
					'cliente' 		=> $cliente,
					'relacionados' 	=> $relacionados,

					'nombre_pagina' => lang('relacionar')
				);

				plantilla("{$this->controlador}/relacionar", $datos);
			}
			else
				redirect($this->controlador);
		}

		function anadir_relacion($id = null, $id_producto = null)
		{
			if (is_numeric($id) && is_numeric($id_producto))
			{
				$insert = array(
					'id_cliente' 	=> $id,
					'id_producto' 	=> $id_producto,
				);

				$this->db->insert('clientes_productos', $insert);
			}

			redirect($this->agent->referrer());
		}

		function borrar_relacion($id = null, $id_producto = null)
		{
			if (is_numeric($id) && is_numeric($id_producto))
			{
				$this->db->where('id_cliente', $id);
				$this->db->where('id_producto', $id_producto);
				$this->db->delete('clientes_productos');
			}

			redirect($this->agent->referrer());
		}
	}

?>