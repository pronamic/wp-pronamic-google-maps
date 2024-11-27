<?php

/**
 * Template snippet
 */
if ( function_exists( 'pronamic_google_maps' ) ) {
	pronamic_google_maps(
		[
			'width'       => 800,
			'height'      => 800,
			// https://developers.google.com/maps/documentation/javascript/reference#MapOptions
			'map_options' => [
				'minZoom' => 5,
				'maxZoom' => 10,
			],
		]
	);

	$latitude  = get_post_meta( get_the_ID(), '_pronamic_google_maps_latitude', true );
	$longitude = get_post_meta( get_the_ID(), '_pronamic_google_maps_longitude', true );

	$daddr = $latitude . ',' . $longitude;

	printf(
		'<a href="%s" target="_blank">%s</a>',
		esc_attr( add_query_arg( 'daddr', $daddr, 'https://www.google.com/maps' ) ),
		esc_html__( 'View directions', 'text_domain' )
	);
}
