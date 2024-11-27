<?php

if ( function_exists( 'pronamic_google_maps' ) ) {
	pronamic_google_maps(
		[
			'width'       => 800,
			'height'      => 800,
			'map_options' => [
				'minZoom' => 5,
				'maxZoom' => 10,
			],
		] 
	);
}
