<?php

/**
 * Filter snippet
 */
function prefix_pronamic_google_maps_marker_options_icon( $url ) {
	$categories = get_the_category();
	$category   = array_shift( $categories );

	if ( ! empty( $category ) ) {
		// Store your icons as .png files in your (child)theme in the folder '/icons/'
		$path = '/icons/' . $category->slug . '.png';
		$file = get_stylesheet_directory() . $path;

		if ( file_exists( $file ) ) {
			$url = get_stylesheet_directory_uri() . $path;
		}
	}

	return $url;
}

add_filter( 'pronamic_google_maps_marker_options_icon', 'prefix_pronamic_google_maps_marker_options_icon' );

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
			'width'          => 800,
			'height'         => 800,
			'map_type_id'    => 'satellite',
			'marker_options' => [
				'icon' => 'http://google-maps-icons.googlecode.com/files/photo.png',
			],
		]
	);
}
