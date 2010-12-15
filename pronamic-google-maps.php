<?php
/*
Plugin Name: Pronamic Google Maps
Plugin URI: http://pronamic.eu/wordpress/google-maps/
Description: This plugin makes it simple to add Google Maps to your WordPress post, pages or other custom post types.
Version: 1.4
Requires at least: 3.0
Author: Pronamic
Author URI: http://pronamic.eu/
License: GPL
*/

require_once 'classes/Pronamic.php';
require_once 'classes/Pronamic_Google_Maps.php';
require_once 'classes/Pronamic_Google_Maps_LatLng.php';
require_once 'classes/Pronamic_Google_Maps_Info.php';
require_once 'classes/Pronamic_Google_Maps_Admin.php';
require_once 'classes/Pronamic_Google_Maps_OptionPage.php';
require_once 'classes/Pronamic_Google_Maps_MetaBox.php';
require_once 'classes/Pronamic_Google_Maps_Widget.php';

Pronamic_Google_Maps::$baseName = plugin_basename(__FILE__);
Pronamic_Google_Maps::$pluginPath = plugin_dir_path(__FILE__);
Pronamic_Google_Maps::$pluginUrl = plugin_dir_url(__FILE__);

$pgm = new Pronamic_Google_Maps();

function pronamic_get_google_maps_meta() {
	return Pronamic_Google_Maps::getMetaData();
}

function pronamic_google_maps_title($arguments) {
	$pgm = Pronamic_Google_Maps::getMetaData();

	echo $pgm->title;
}

function pronamic_google_maps_description($arguments) {
	$pgm = Pronamic_Google_Maps::getMetaData();

	echo $pgm->description;
}

function pronamic_google_maps_location() {
	$pgm = Pronamic_Google_Maps::getMetaData();

	echo $pgm->latitude, ', ', $pgm->longitude;
}

function pronamic_google_maps($arguments) {
	Pronamic_Google_Maps::render($arguments);
}
