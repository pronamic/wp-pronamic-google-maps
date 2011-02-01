<?php

function pronamic_get_google_maps_meta() {
	return Pronamic_Google_Maps::getMetaData();
}

function pronamic_is_google_maps_active() {
	return get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_ACTIVE, true);
}

function pronamic_google_maps_title($arguments) {
	echo get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_TITLE, true);
}

function pronamic_google_maps_description($arguments) {
	echo get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_DESCRIPTION, true);
}

function pronamic_google_maps_location() {
	$latitude = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_LATITUDE, true);
	$longitude = get_post_meta($post->ID, Pronamic_Google_Maps::META_KEY_LONGITUDE, true);

	echo $latitude, ', ', $longitude;
}

function pronamic_google_maps($arguments) {
	Pronamic_Google_Maps::render($arguments);
}
