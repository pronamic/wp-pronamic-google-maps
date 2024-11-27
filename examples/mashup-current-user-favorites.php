<?php

/**
 * Template snippet
 */
if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
	// http://codex.wordpress.org/Function_Reference/get_current_user_id
	$user_id = get_current_user_id();

	// http://codex.wordpress.org/Function_Reference/get_user_meta
	$favorite_villas = get_user_meta( $user_id, 'favorite_villas', false );

	// http://codex.wordpress.org/Function_Reference/WP_Query#Parameters
	$query = new WP_Query(
		[
			'post_type'      => 'villa',
			'posts_per_page' => 50,
			'post__in'       => $favorite_villas,
		] 
	);

	// Mashup
	pronamic_google_maps_mashup(
		$query,
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
