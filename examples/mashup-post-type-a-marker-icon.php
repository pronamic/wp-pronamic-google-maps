<?php

/**
 * Template snippet
 */
if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
	pronamic_google_maps_mashup(
		array(
			'post_type'      => 'post_type_a',
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
