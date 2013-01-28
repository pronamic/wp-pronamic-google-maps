<?php

/**
 * Filter snippet
 * 
 * @see https://developers.google.com/maps/documentation/javascript/reference#MarkerOptions
 */
function prefix_pronamic_google_maps_marker_options( $marker_options ) {
	// icon - Icon for the foreground
	$marker_options['icon']      = 'http://google-maps-icons.googlecode.com/files/home.png';
	// shadow - Shadow image
	$marker_options['shadow']    = 'http://google-maps-icons.googlecode.com/files/shadow.png';
	// draggable -  	If true, the marker can be dragged. Default value is false.
	$marker_options['draggable'] = true;

	return $marker_options;
}

add_filter( 'pronamic_google_maps_marker_options', 'prefix_pronamic_google_maps_marker_options' );
