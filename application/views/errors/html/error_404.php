<?php

	if ($_SERVER['SERVER_NAME'] == 'localhost')
		$site_url = 'http://' . $_SERVER['SERVER_NAME'] . '/' . current(array_filter(explode('/', $_SERVER['PHP_SELF']))) . '/';
	else
		$site_url = 'http://' . $_SERVER['SERVER_NAME'];

	echo '<!DOCTYPE html>';

		echo '<head>';

			echo '<meta charset="UTF-8">';

			echo '<title>' . '404 - Página no encontrada' . '</title>';

		echo '</head>';

		echo '<body>';

			echo '<div class="texto">';

				echo '<h1 class="titulo">' . '404 - Página no encontrada' . '</h1>';

				echo '<span class="descripcion">' . 'La página a la que ha intentado acceder no existe. Pulse el botón para volver a la web.' . '</span>';

				echo '<a href="' . $site_url . '" class="volver uppercase transicion">' . 'Inicio' . '</a>';

			echo '</div>';

		echo '</body>';

	echo '</html>';

?>

<style>

	body {
		position: relative;
		min-height: 100vh;
		margin: 0;
		font-family: 'Segoe UI', 'Helvetica Neue', 'Helvetica', sans-serif;
		font-size: 62.5%;
		color: #444444;
	}

	h1, h2, h3 {
		display: inline-block;
		margin: 0;
		font-size: 1em;
	}

	a {
		text-decoration: none;
	}

	.uppercase {
		text-transform: uppercase;
	}

	.transicion {
		-moz-transition: all 250ms linear;
		-ms-transition: all 250ms linear;
		-o-transition: all 250ms linear;
		-webkit-transition: all 250ms linear;
		transition: all 250ms linear;
	}

	.texto {
		position: absolute;
		top: 50%;
		left: 0;
		right: 0;
		width: 90%;
		margin: 0 auto;
		text-align: center;
		-webkit-transform: translate(0, -50%);
		-moz-transform: translate(0, -50%);
		-o-transform: translate(0, -50%);
		-ms-transform: translate(0, -50%);
		transform: translate(0, -50%);
	}

	.texto .titulo {
		display: block;
	    font-size: 3.5em;
    	font-weight: 300;
		line-height: 1em;
	}

	.texto .descripcion {
		display: block;
		margin-top: 40px;
		font-size: 1.65em;
    	line-height: 1.75em;
	}

	.texto .volver {
		display: inline-block;
		vertical-align: middle;
		margin-top: 40px;
		padding: 0 25px;
		border-radius: 5px;
		font-size: 1.4em;
		line-height: 40px;
		color: #ffffff;
		background: #008396;
	}

	.texto .volver:hover {
		box-shadow: 0 5px 10px 0 rgba(0, 0, 0, .25);
	}

</style>