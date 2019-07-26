<?php

	echo form_open();

		if ($cargar == 0)
		{
			echo '<div class="vacio">';

				echo '<span>' . lang('productos_vacio') . '</span>';

				echo '<div class="botones">';

					echo anchor("{$controlador}/cargar", lang('cargar'), 'class="boton uppercase transicion" title="' . lang('cargar') . '"');

					echo anchor("resources/{$controlador}/{$controlador}.json", lang('ver_fichero'), 'class="boton blanco uppercase transicion" title="' . lang('ver_fichero') . '" target="_blank"');

					echo anchor('', lang('volver'), 'class="boton blanco uppercase transicion" title="' . lang('volver') . '"');

				echo '</div>';

			echo '</div>';
		}
		else
		{
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

					echo anchor('', lang('volver'), 'class="boton uppercase transicion" title="' . lang('volver') . '"');

				echo '</div>';

				echo '<div class="limpia"></div>'; 

			echo '</div>';

			if ($rs->num_rows() > 0)
			{
				echo '<table class="listado" cellspacing="0">';

					echo '<tr>';
					
						echo '<th rel="codigo">' . '<span>' . lang('campo.codigo') . '</span>' . '</th>';
						echo '<th width="200" align="left" rel="nombre">' . '<span>' . lang('campo.nombre') . '</span>' . '</th>';
						echo '<th rel="precio">' . '<span>' . lang('campo.precio') . '</span>' . '</th>';
						echo '<th align="left" rel="descripcion">' . '<span>' . lang('campo.descripcion') . '</span>' . '</th>';

					echo '</tr>';

					foreach ($rs->result_array() as $fila)
					{
						$codigo 		= $fila['codigo'];
						$nombre 		= $fila['nombre'];
						$precio 		= number_format($fila['precio'], 2, ',', '.') . nbs() . '€';
						$descripcion 	= $fila['descripcion'];

						echo '<tr>';

							echo '<td align="center">' . $codigo . '</td>'; 
							echo '<td>' . $nombre . '</td>'; 
							echo '<td align="center">' . $precio . '</td>'; 
							echo '<td>' . $descripcion . '</td>'; 
						
						echo '</tr>';
					}


				echo '</table>';
			}
		}

		echo form_hidden('campo_orden', $campo_orden);
		echo form_hidden('tipo_orden', $tipo_orden);

	echo form_close();

?>