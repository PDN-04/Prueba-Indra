<?php

	echo form_open();

		echo '<div class="filtros">';

			echo '<div class="buscador">';

				echo '<div class="campo">';

					echo form_input('busqueda', $busqueda, 'placeholder="' . lang('buscar') . '...' . '"');

				echo '</div>';

				echo anchor('javascript:void(0)', lang('buscar'), 'class="buscar boton uppercase transicion" title="' . lang('buscar') . '"');

				if ($busqueda != '' || $campo_orden != '' || $tipo_orden != '')
					echo anchor('javascript:void(0)', lang('limpiar'), 'class="limpiar boton blanco uppercase transicion" title="' . lang('limpiar') . '"');

			echo '</div>';

			echo '<div class="botones">';

				echo anchor("{$controlador}/nuevo", lang('nuevo'), 'class="boton blanco uppercase transicion" title="' . lang('nuevo') . '"');

				echo anchor('', lang('volver'), 'class="boton uppercase transicion" title="' . lang('volver') . '"');

			echo '</div>';

			echo '<div class="limpia"></div>'; 

		echo '</div>';

		if ($rs->num_rows() > 0)
		{
			echo '<table class="listado" cellspacing="0">';

				echo '<tr>';
				
					echo '<th rel="dni">' . '<span>' . lang('campo.dni') . '</span>' . '</th>';
					echo '<th align="left" rel="nombre">' . '<span>' . lang('campo.nombre') . '</span>' . '</th>';
					echo '<th align="left" rel="apellidos">' . '<span>' . lang('campo.apellidos') . '</span>' . '</th>';
					echo '<th align="left" rel="email">' . '<span>' . lang('campo.email') . '</span>' . '</th>';
					echo '<th></th>';

				echo '</tr>';

				foreach ($rs->result_array() as $fila)
				{
					$id 			= $fila['id_cliente'];
					$dni 			= $fila['dni'];
					$nombre 		= $fila['nombre'];
					$apellidos 		= $fila['apellidos'];
					$email 			= $fila['email'];

					echo '<tr>';

						echo '<td align="center">' . $dni . '</td>'; 
						echo '<td>' . $nombre . '</td>'; 
						echo '<td>' . $apellidos . '</td>'; 
						echo '<td>' . $email . '</td>'; 

						echo '<td class="opciones">';

							echo anchor("{$controlador}/relacionar/{$id}", ' ', 'class="relacionar transicion" title="' . lang('relacionar') . '"');

							echo anchor("{$controlador}/editar/{$id}", ' ', 'class="editar transicion" title="' . lang('editar') . '"');

							echo anchor("{$controlador}/borrar/{$id}", ' ', 'class="borrar transicion" title="' . lang('borrar') . '"');

						echo '</td>';
					
					echo '</tr>';
				}


			echo '</table>';
		}

		echo form_hidden('campo_orden', $campo_orden);
		echo form_hidden('tipo_orden', $tipo_orden);

	echo form_close();

?>