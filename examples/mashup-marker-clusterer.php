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
			'width'                    => 800,
			'height'                   => 800,
			'map_type_id'              => 'satellite',
			// http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/docs/reference.html#MarkerClustererOptions
			'marker_clusterer_options' => [
				'gridSize' => 60,
			],
		]
	);
}
