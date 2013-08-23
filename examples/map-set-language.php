<?php

/**
 * Filter snippet
 * 
 * @see https://developers.google.com/loader/?hl=nl#GoogleLoad
 * @see https://developers.google.com/maps/documentation/javascript/basics#Language
 */
function prefix_pronamic_google_maps_load_other_params_array( $other_params ) {
	$other_params['language'] = 'ja';

	return $other_params;
}

add_filter( 'pronamic_google_maps_load_other_params_array', 'prefix_pronamic_google_maps_load_other_params_array' );
