<?php

function pronamic_get_google_maps_meta() {
	return Pronamic_Google_Maps_Maps::getMetaData();
}

function pronamic_google_maps_is_active() {
	global $post;

	$active = get_post_meta($post->ID, Pronamic_Google_Maps_Post::META_KEY_ACTIVE, true);

	return filter_var($active, FILTER_VALIDATE_BOOLEAN);
}

function pronamic_google_maps_title() {
	global $post;

	$title = get_post_meta($post->ID, Pronamic_Google_Maps_Post::META_KEY_TITLE, true);

	echo apply_filters(Pronamic_Google_Maps_Filters::FILTER_TITLE, $title);
}

function pronamic_google_maps_description() {
	global $post;

	$description = get_post_meta($post->ID, Pronamic_Google_Maps_Post::META_KEY_DESCRIPTION, true);

	echo apply_filters(Pronamic_Google_Maps_Filters::FILTER_DESCRIPTION, $description);
}

function pronamic_google_maps_location() {
	global $post;

	$latitude = get_post_meta($post->ID, Pronamic_Google_Maps_Post::META_KEY_LATITUDE, true);
	$longitude = get_post_meta($post->ID, Pronamic_Google_Maps_Post::META_KEY_LONGITUDE, true);

	echo $latitude, ', ', $longitude;
}

function pronamic_google_maps_geo_microformat($arguments = array()) {
	return Pronamic_Google_Maps_GeoMicroformat::render($arguments);
}

function pronamic_google_maps($arguments = array()) {
	return Pronamic_Google_Maps_Maps::render($arguments);
}

function pronamic_google_maps_mashup($query = array(), $arguments = array()) {
	return Pronamic_Google_Maps_Mashup::render($query, $arguments);
}
