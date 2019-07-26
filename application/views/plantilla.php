<?php

	echo '<!DOCTYPE html lang="es">';

		echo '<head>';

			echo '<meta charset="UTF-8">';
			echo '<meta name="google-site-verification" content="HyCGnxhX7l1jfaOzM9PaJNK8esZ1CV-ddtxApkebnP4" />';
			echo '<meta name="robots" content="index,follow,all" />';
			echo '<meta name="GOOGLEBOT" content="index,follow,all" />';

			echo '<title>' . $this->config->item('nombre_web') . '</title>';

			echo '<meta name="description" content="" />';
			echo '<meta name="keywords" content="" />';

			echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />';
			echo '<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />';
			echo '<meta name="format-detection" content="telephone=no" />';
			echo '<meta http-equiv="Content-Language" content="es"/>';;

			echo link_tag('js/jquery-ui/jquery-ui.min.css');
			echo link_tag('https://fonts.googleapis.com/css?family=Roboto+Mono:300,400,500,700');
			echo link_tag('css/css.css');
			echo link_tag('css/responsive.css');

		echo '</head>';

		echo '<body>';

			$this->load->view('cabecera');

			$this->load->view('error');

			echo $body;

			echo '<script type="text/javascript" src="' . site_url('js/jquery/jquery-3.3.1.js') . '"></script>';
			echo '<script type="text/javascript" src="' . site_url('js/jquery-ui/jquery-ui.min.js') . '"></script>';
			echo '<script type="text/javascript" src="' . site_url('js/jquery/cookie-bar.js') . '"></script>';
			echo '<script type="text/javascript" src="' . site_url('js/lazysizes/lazysizes.min.js') . '"></script>';
			echo '<script type="text/javascript" src="' . site_url('js/js.js') . '"></script>';

		echo '</body>';

	echo '</html>';

	echo '<script type="text/javascript">';

		echo 'var site_url 	= "' . site_url() . '";';
		echo 'var admin_url = "' . site_url('admin') . '";';

	echo '</script>';

?>