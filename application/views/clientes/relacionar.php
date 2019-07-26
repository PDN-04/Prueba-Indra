<?php

	echo form_open();

		echo '<div class="filtros">';

			echo '<span>' . lang('buscar_productos') . '</span>';

			echo '<div class="limpia"></div>'; 

			echo '<div class="buscador">';

				echo '<div class="campo">';

					echo form_input('busqueda', $busqueda, 'placeholder="' . lang('buscar') . '...' . '"');

				echo '</div>';

				echo anchor('javascript:void(0)', lang('buscar'), 'class="buscar boton uppercase transicion" title="' . lang('buscar') . '"');

				if ($busqueda != '')
					echo anchor('javascript:void(0)', lang('limpiar'), 'class="limpiar boton blanco uppercase transicion" title="' . lang('limpiar') . '"');

			echo '</div>';

			echo '<div class="botones">';

				echo anchor($controlador, lang('volver'), 'class="boton uppercase transicion" title="' . lang('volver') . '"');

			echo '</div>';

			echo '<div class="limpia"></div>'; 

		echo '</div>';

		if ($busqueda != '' && $rs->num_rows() > 0 && ($rs->num_rows() != sizeof($relacionados)))
		{
			echo '<table class="listado especial" cellspacing="0">';

				echo '<tr>';
				
					echo '<th width="200" align="left" rel="nombre">' . '<span>' . lang('campo.nombre') . '</span>' . '</th>';
					echo '<th></th>';

				echo '</tr>';

				foreach ($rs->result_array() as $fila)
				{
					$id_producto 	= $fila['id_producto'];
					$nombre 		= $fila['nombre'];
					
					if (!array_key_exists($id_producto, $relacionados))
					{
						echo '<tr>';

							echo '<td>' . $nombre . '</td>'; 

							echo '<td class="opciones">';

								echo anchor("{$controlador}/anadir_relacion/{$id}/{$id_producto}", ' ', 'class="relacionar transicion" title="' . lang('relacionar') . '"');

							echo '</td>';
						
						echo '</tr>';
					}
				}


			echo '</table>';
		}

		if (sizeof($relacionados) > 0)
		{
			echo '<div class="relacionados">';

				echo '<span>' . sprintf(lang('relacionados'), $cliente['nombre']) . '</span>';
				
				echo '<ul>';

					foreach ($relacionados as $id_producto => $nombre)
						echo '<li>' . anchor("clientes/borrar_relacion/{$id}/{$id_producto}", $nombre, 'class="transicion" title="' . $nombre . '"') .  '</li>';

				echo '</ul>';

			echo '</div>';
		}

	echo form_close();

?>