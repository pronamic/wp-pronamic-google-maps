<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete meta
global $wpdb;

$wpdb->query(
	$wpdb->prepare(
		"DELETE FROM $wpdb->postmeta WHERE meta_key IN ( %s, %s, %s, %s, %s, %s, %s, %s, %s )",
		'_pronamic_google_maps_active',
		'_pronamic_google_maps_address',
		'_pronamic_google_maps_description',
		'_pronamic_google_maps_geocode_status',
		'_pronamic_google_maps_latitude',
		'_pronamic_google_maps_longitude',
		'_pronamic_google_maps_map_type',
		'_pronamic_google_maps_title',
		'_pronamic_google_maps_zoom'
	)
);

// Delete options
delete_option( 'Pronamic_Google_maps' );

delete_option( '_pronamic_google_maps_fresh_design' );
