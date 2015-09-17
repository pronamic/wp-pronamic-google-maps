<?php

if ( function_exists( 'pronamic_google_maps' ) ) {
	pronamic_google_maps( array(
		'width'       => 800,
		'height'      => 800,
		'map_options' => array(
			'minZoom' => 5,
			'maxZoom' => 10,
		),
	) );
}
