<?php

if ( function_exists( 'pronamic_google_maps_mashup' ) ) {
	pronamic_google_maps_mashup(
		[
			'post_type'      => 'post',
			'posts_per_page' => 50,
		],
		[
			'width'                                 => 800,
			'height'                                => 800,
			'overlapping_marker_spiderfier_options' => [
				'markersWontMove'        => false,
				'markersWontHide'        => false,
				'keepSpiderfied'         => false,
				'nearbyDistance'         => 20,
				'circleSpiralSwitchover' => 9,
				'legWeight'              => 1.5,
			],
		]
	);
}
