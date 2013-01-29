<?php

/**
 * Filter snippet
 */
function prefix_pronamic_google_maps_item_description( $description ) {
	global $post;

	$description = get_post_meta( $post->ID, '_pronamic_google_maps_address', true );

	return $description;
}

add_filter( 'pronamic_google_maps_item_description', 'prefix_pronamic_google_maps_item_description' );
