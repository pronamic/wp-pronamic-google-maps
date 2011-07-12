<?php
/*
Plugin Name: Pronamic Google Maps
Plugin URI: http://pronamic.eu/wordpress/google-maps/
Description: This plugin makes it simple to add Google Maps to your WordPress post, pages or other custom post types.
Version: 1.9
Requires at least: 3.0
Author: Pronamic
Author URI: http://pronamic.eu/
License: GPL
*/

function pronamic_google_maps_autoload($name) {
	$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $name . '.php';
	$file = str_replace('\\', DIRECTORY_SEPARATOR, $file);

	if(is_readable($file)) {
		require_once $file;
	}
}

require_once 'functions.php';

spl_autoload_register('pronamic_google_maps_autoload');

Pronamic_Google_Maps::bootstrap(__FILE__);
