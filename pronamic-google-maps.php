<?php
/*
Plugin Name: Pronamic Google Maps
Plugin URI: http://pronamic.nl/
Description: This plugin makes it simple to add Google Maps to your WordPress post, pages or other custom post types.
Author: Pronamic
Version: 1.0
Requires at least: 3.0
Author URI: http://pronamic.nl/
License: GPL
*/

require_once 'classes/Pronamic_Google_Maps.php';
require_once 'classes/Pronamic_Google_Maps_Admin.php';
require_once 'classes/Pronamic_Google_Maps_OptionPage.php';
require_once 'classes/Pronamic_Google_Maps_MetaBox.php';

Pronamic_Google_Maps::$pluginPath = plugin_dir_path(__FILE__);
Pronamic_Google_Maps::$pluginUrl = plugin_dir_url(__FILE__);

$pgm = new Pronamic_Google_Maps();

function pronamic_get_google_maps_meta() {
	global $post;

	$meta = new stdClass();

	$active = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_ACTIVE, true);
	$meta->active = filter_var($active, FILTER_VALIDATE_BOOLEAN);

	$meta->latitude = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_LATITUDE, true);
	$meta->longitude = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_LONGITUDE, true);

	$meta->title = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_TITLE, true);
	$meta->description = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_DESCRIPTION, true);

	return $meta;
}

function pronamic_google_maps_title($arguments) {
	$pgm = pronamic_get_google_maps_meta();

	echo $pgm->title;
}

function pronamic_google_maps_description($arguments) {
	$pgm = pronamic_get_google_maps_meta();

	echo $pgm->description;
}

function pronamic_google_maps($arguments) {
	$defaults = array(
		'width' => 500 ,
		'height' => 300 , 
		'static' => false 
	);

	$arguments = wp_parse_args($arguments, $defaults);

	$options = Pronamic_Google_Maps::getOptions();
	$activeTypes = $options['active'];

	global $post;

	$pgm = pronamic_get_google_maps_meta();

	$active = isset($activeTypes[$post->post_type]) && $activeTypes[$post->post_type];

	if($active && $pgm->active): ?>

	<div id="pronamic-google-maps-canvas">
		<?php 

		$url = 'http://maps.google.com/maps/api/staticmap?';

		$parameters = array();
		$parameters['center'] = $pgm->latitude . ',' . $pgm->longitude;
		$parameters['zoom'] = 12;
		$parameters['size'] = $arguments['width'] . 'x' . $arguments['height'];
		$parameters['maptype'] = 'roadmap';
		$parameters['sensor'] = 'false';
		$parameters['markers'] = 'color:0xFFD800|label:M|' . $pgm->latitude . ',' . $pgm->longitude;

		$url .= http_build_query($parameters, '', '&amp;');

		?>

		<input type="hidden" name="<?php echo Pronamic_Google_Maps::META_KEY_LATITUDE; ?>" value="<?php echo esc_attr($pgm->latitude); ?>" />
		<input type="hidden" name="<?php echo Pronamic_Google_Maps::META_KEY_LONGITUDE; ?>" value="<?php echo esc_attr($pgm->longitude); ?>" />
		<input type="hidden" name="<?php echo Pronamic_Google_Maps::META_KEY_TITLE; ?>" value="<?php echo esc_attr($pgm->title); ?>" />
		<input type="hidden" name="<?php echo Pronamic_Google_Maps::META_KEY_DESCRIPTION; ?>" value="<?php echo esc_attr($pgm->description); ?>" />

		<p class="pgm-static-map">
			<img src="<?php echo $url; ?>" alt="" />
		</p>
	</div>

	<?php endif; 
}
