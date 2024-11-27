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
				'mapTypeControl'    => false,
				'navigationControl' => false,
				'streetViewControl' => false,
				'scrollwheel'       => false,
				'zoomControl'       => false,
			],
		] 
	);
}
