<?php

/**
 * Template snippet
 */
if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
	pronamic_google_maps_mashup(
		[
			'post_type'      => 'post',
			'posts_per_page' => 50,
		],
		[
			'width'       => 800,
			'height'      => 800,
			'map_type_id' => 'satellite',
			'latitude'    => 52,
			'longitude'   => 8,
			'zoom'        => 4,
			'fit_bounds'  => false,
		]
	);
}
