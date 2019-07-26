<?php
	
	if (validation_errors() != '')
	{
		echo '<div class="fondo_error">';

			echo '<div class="error">';

				if (validation_errors() != '')
					echo '<ul>' . validation_errors() . '</ul>';

				echo anchor('javascript:void(0)', ' ', 'class="cerrar_error transicion"');

			echo '</div>';

		echo '</div>';
	}

?>