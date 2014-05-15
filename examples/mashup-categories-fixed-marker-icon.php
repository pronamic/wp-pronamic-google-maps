<?php

/**
 * Filter snippet
 */
function prefix_pronamic_google_maps_marker_options_icon( $url ) {
	if ( has_category( 'airport' ) ) {
		return 'http://google-maps-icons.googlecode.com/files/airport.png';
	} elseif ( has_category( 'bar' ) ) {
		return 'http://google-maps-icons.googlecode.com/files/bar.png';
	} elseif ( has_category( 'beach' ) ) {
		return 'http://google-maps-icons.googlecode.com/files/beach.png';
	} else {
		return $url;
	}
}

add_filter( 'pronamic_google_maps_marker_options_icon', 'prefix_pronamic_google_maps_marker_options_icon' );

/**
 * Template snippet
 */
if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
	pronamic_google_maps_mashup(
		array(
			'post_type'      => 'post',
			'nopaging'       => true,
		),
		array(
			'width'          => 800,
			'height'         => 800,
			'map_type_id'    => 'satellite',
			'marker_options' => array(
				'icon' => 'http://google-maps-icons.googlecode.com/files/photo.png',
			),
		)
	);
}
