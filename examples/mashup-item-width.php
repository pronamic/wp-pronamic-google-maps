<?php

/**
 * Filter snippet
 */
function prefix_pronamic_google_maps_mashup_item( $content ) {
	$content  = '';

	$content .=	'<div style="width: 250px">';

	$content .= sprintf(
		'<a href="%s">%s</a>',
		esc_attr( get_permalink() ),
		get_the_title()
	);

	$content .= '</div>';

	return $content;
}

add_filter( 'pronamic_google_maps_mashup_item', 'prefix_pronamic_google_maps_mashup_item' );
