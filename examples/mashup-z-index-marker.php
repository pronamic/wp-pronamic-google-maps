<?php

/**
 * Filter snippet
 */
function prefix_pronamic_google_maps_marker_options_zindex( $z_index ) {
	global $post;

	$featured = get_post_meta( $post->ID, '_custom_key_featured', true );

	if ( $featured ) {
		$z_index = 1000001;
	} else {
		$z_index = 1000000;
	}

	return $z_index;
}

add_filter( 'pronamic_google_maps_marker_options_zIndex', 'prefix_pronamic_google_maps_marker_options_zindex' );

/**
 * Template snippet
 */
if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
	pronamic_google_maps_mashup( 
		array(
			'post_type'      => array( 'post_type_a', 'post_type_b' ), 
			'nopaging'       => true
		), array(
			'width'          => 800,
			'height'         => 800,
			'map_type_id'    => 'satellite',
			'marker_options' => array(
				'icon' => 'http://google-maps-icons.googlecode.com/files/photo.png'
			)
		)
	);
}
