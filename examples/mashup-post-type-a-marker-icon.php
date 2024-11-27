<?php

/**
 * Template snippet
 */
if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
	pronamic_google_maps_mashup(
		[
			'post_type'      => 'post_type_a',
			'posts_per_page' => 50,
		],
		[
			'width'          => 800,
			'height'         => 800,
			'map_type_id'    => 'satellite',
			'marker_options' => [
				'icon' => 'http://google-maps-icons.googlecode.com/files/photo.png',
			],
		]
	);
}
