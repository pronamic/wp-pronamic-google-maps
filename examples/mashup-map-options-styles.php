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
			'map_options' => [
				// https://developers.google.com/maps/documentation/javascript/styling
				// http://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html
				'styles' => [
					(object) [
						'featureType' => 'water',
						'stylers'     => [
							(object) [ 'visibility' => 'on' ],
							(object) [ 'hue' => '#ff0011' ],
						],
					],
				],
			],
		]
	);
}
