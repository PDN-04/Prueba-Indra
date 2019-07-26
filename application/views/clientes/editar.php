<?php

	echo form_open();

		echo '<div class="formulario">';

			echo '<div class="campo">';

				echo form_input('nombre', $nombre, 'placeholder="' . lang('campo.nombre') . '"');

			echo '</div>';

			echo '<div class="campo">';

				echo form_input('apellidos', $apellidos, 'placeholder="' . lang('campo.apellidos') . '"');

			echo '</div>';

			echo '<div class="campo">';

				echo form_input('dni', $dni, 'placeholder="' . lang('campo.dni') . '"');

			echo '</div>';

			echo '<div class="campo">';

				echo form_input('direccion', $direccion, 'placeholder="' . lang('campo.direccion') . '"');

			echo '</div>';

			echo '<div class="campo">';

				echo form_input('telefono', $telefono, 'placeholder="' . lang('campo.telefono') . '"');

			echo '</div>';

			echo '<div class="campo">';

				echo form_input('email', $email, 'placeholder="' . lang('campo.email') . '"');

			echo '</div>';

			echo '<div class="botones">';

				echo anchor('javascript:void(0)', lang('guardar'), 'class="guardar boton uppercase transicion" title="' . lang('guardar') . '"');

				echo anchor("{$controlador}", lang('volver'), 'class="boton blanco uppercase transicion" title="' . lang('volver') . '"');

			echo '</div>';

		echo '</div>';

	echo form_close();

?>