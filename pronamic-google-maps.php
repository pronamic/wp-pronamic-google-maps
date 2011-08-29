<?php
/*
Plugin Name: Pronamic Google Maps
Plugin URI: http://pronamic.eu/wordpress/google-maps/
Description: This plugin makes it simple to add Google Maps to your WordPress post, pages or other custom post types.
Version: 2.1.1
Requires at least: 3.0
Author: Pronamic
Author URI: http://pronamic.eu/
License: GPL
*/

if(function_exists('spl_autoload_register')):

function pronamic_google_maps_autoload($name) {
	$name = str_replace('\\', DIRECTORY_SEPARATOR, $name);

	$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $name . '.php';

	if(is_file($file)) {
		require_once $file;
	}
}

spl_autoload_register('pronamic_google_maps_autoload');

require_once 'functions.php';

Pronamic_Google_Maps::bootstrap(__FILE__);

endif;
