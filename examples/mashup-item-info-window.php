<?php

/**
 * Filter snippet
 */
function prefix_pronamic_google_maps_mashup_item( $content ) {
	$content  = '';

	$content .= '<a href="'. get_permalink() .'">';
	$content .= 	get_the_title();
	$content .= '</a>';

	$content .= '<br />';
	
	$content .= get_the_post_thumbnail( get_the_ID(), 'thumbnail' );

	$content .= '<br />';

	$content .= get_the_tag_list( 'Tags: ', ', ','' );

	return $content;
}

add_filter( 'pronamic_google_maps_mashup_item', 'prefix_pronamic_google_maps_mashup_item' );
