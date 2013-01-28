<?php

/**
 * Template snippet
 */
if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
	pronamic_google_maps_mashup(
		array(
			'post_type'   => 'post',
			'nopaging'    => true
		),
		array(
			'width'       => 800,
			'height'      => 800,
			'map_options' => array(
				// https://developers.google.com/maps/documentation/javascript/styling
				// http://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html
				'styles' => array(
					(object) array(
						'featureType' => 'water',
						'stylers'     => array(
							(object) array( 'visibility' => 'on' ),
							(object) array( 'hue'        => '#ff0011' )
						)
					)
				)
			)
		)
	);
}
