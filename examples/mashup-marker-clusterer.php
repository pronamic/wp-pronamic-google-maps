<?php

/**
 * Template snippet
 */
if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
	pronamic_google_maps_mashup(
		array(
			'post_type'                => 'post',
			'nopaging'                 => true
		), array(
			'width'                    => 800,
			'height'                   => 800,
			'map_type_id'              => 'satellite',
			// http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/docs/reference.html#MarkerClustererOptions
			'marker_clusterer_options' => array(
				'gridSize' => 60
			)
		)
	);
}
