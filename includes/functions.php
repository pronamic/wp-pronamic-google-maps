<?php

function pronamic_get_google_maps_meta() {
	return Pronamic_Google_Maps_Maps::get_meta_data();
}

function pronamic_google_maps_is_active() {
	global $post;

	$active = get_post_meta( $post->ID, '_pronamic_google_maps_active', true );

	return filter_var( $active, FILTER_VALIDATE_BOOLEAN );
}

function pronamic_google_maps_title() {
	global $post;

	$title = get_post_meta( $post->ID, '_pronamic_google_maps_title', true );

	echo wp_kses_post( apply_filters( 'pronamic_google_maps_item_title', $title ) );
}

function pronamic_google_maps_description() {
	global $post;

	$description = get_post_meta( $post->ID, '_pronamic_google_maps_description', true );

	echo wp_kses_post( apply_filters( 'pronamic_google_maps_item_description', $description ) );
}

function pronamic_google_maps_location() {
	global $post;

	$latitude  = get_post_meta( $post->ID, '_pronamic_google_maps_latitude', true );
	$longitude = get_post_meta( $post->ID, '_pronamic_google_maps_longitude', true );

	echo esc_html( $latitude . ', ' . $longitude );
}

function pronamic_google_maps_geo_microformat( $args = array() ) {
	return Pronamic_Google_Maps_GeoMicroformat::render( $args );
}

function pronamic_google_maps( $args = array() ) {
	return Pronamic_Google_Maps_Maps::render( $args );
}

function pronamic_google_maps_mashup( $query = array(), $args = array() ) {
	return Pronamic_Google_Maps_Mashup::render( $query, $args );
}
