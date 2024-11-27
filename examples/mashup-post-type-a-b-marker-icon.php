<?php

/**
 * Filter snippet
 */
function prefix_pronamic_google_maps_marker_options_icon( $url ) {
	switch ( get_post_type() ) {
		case 'post_type_a':
			return 'http://google-maps-icons.googlecode.com/files/seniorsite.png';
		case 'post_type_b':
			return 'http://google-maps-icons.googlecode.com/files/university.png';
	}

	return $url;
}

add_filter( 'pronamic_google_maps_marker_options_icon', 'prefix_pronamic_google_maps_marker_options_icon' );

/**
 * Template snippet
 */
if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
	pronamic_google_maps_mashup(
		[
			'post_type'      => [ 'post_type_a', 'post_type_b' ],
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
