<?php
	
	echo '<div class="principal">';

		echo '<a href="' . site_url('productos') . '" class="izquierda" title="' . lang('productos') . '">';

			echo '<span class="titulo">' . lang('productos') . '</span>';

			echo '<span class="icono productos transicion"></span>';

		echo '</a>';

		echo '<a href="' . site_url('clientes') . '" class="derecha" title="' . lang('clientes') . '">';

			echo '<span class="titulo">' . lang('clientes') . '</span>';

			echo '<span class="icono clientes transicion"></span>';

		echo '</a>';

	echo '</div>';

	echo '<div class="reiniciar">';

		echo anchor('inicio/reiniciar', lang('reiniciar'), 'class="boton uppercase transicion" title="' . lang('reiniciar') . '"');

	echo '</div>';

?>